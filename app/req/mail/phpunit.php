<?php
// PHP framework for testing, based on the design of "JUnit".
// Written by Fred Yankowski <fred@ontosys.com>
//            OntoSys, Inc  <http://www.OntoSys.com>
// License: MIT

error_reporting(E_ALL);

/**
 * Exception class to emulate Java-like exceptions.
 */
class Exception {
    private $message;

    public function __construct($message) {
        $this->message = $message;
    }

    public function getMessage() {
        return $this->message;
    }
}

/**
 * Assertion class with various assertion methods.
 */
class Assert {
    public function assert($boolean, $message = null) {
        if (!$boolean) {
            $this->fail($message);
        }
    }

    public function assertEquals($expected, $actual, $message = null) {
        if ($expected != $actual) {
            $this->failNotEquals($expected, $actual, "expected", $message);
        }
    }

    public function assertRegexp($regexp, $actual, $message = null) {
        if (!preg_match($regexp, $actual)) {
            $this->failNotEquals($regexp, $actual, "pattern", $message);
        }
    }

    private function failNotEquals($expected, $actual, $expectedLabel, $message = null) {
        $str = $message ? ($message . ' ') : '';
        $str .= "($expectedLabel/actual)<br>";
        $htmlExpected = htmlspecialchars($expected);
        $htmlActual = htmlspecialchars($actual);
        $str .= sprintf("<pre>%s\n--------\n%s</pre>", $htmlExpected, $htmlActual);
        $this->fail($str);
    }

    private function fail($message = null) {
        throw new Exception($message ?? "Assertion failed");
    }
}

/**
 * TestCase class that defines the context for running tests.
 */
class TestCase extends Assert {
    private $fName;
    private $fResult;
    private $fExceptions = [];

    public function __construct($name) {
        $this->fName = $name;
    }

    public function run($testResult = null) {
        if (!$testResult) {
            $testResult = $this->_createResult();
        }
        $this->fResult = $testResult;
        $testResult->run($this);
        $this->fResult = null;
        return $testResult;
    }

    public function countTestCases() {
        return 1;
    }

    public function runTest() {
        $name = $this->name();
        $this->$name();
    }

    protected function setUp() {
        // Override for custom setup logic
    }

    protected function tearDown() {
        // Override for custom teardown logic
    }

    protected function _createResult() {
        return new TestResult();
    }

    protected function fail($message = null) {
        $this->fExceptions[] = new Exception($message);
    }

    public function getExceptions() {
        return $this->fExceptions;
    }

    public function name() {
        return $this->fName;
    }

    public function runBare() {
        $this->setUp();
        $this->runTest();
        $this->tearDown();
    }
}

/**
 * TestSuite class to compose and run a set of tests.
 */
class TestSuite {
    private $fTests = [];

    public function __construct($classname = null) {
        if ($classname) {
            $methods = get_class_methods($classname);
            foreach ($methods as $method) {
                if (strpos($method, 'test') === 0) {
                    $this->addTest(new $classname($method));
                }
            }
        }
    }

    public function addTest($test) {
        $this->fTests[] = $test;
    }

    public function run($testResult) {
        foreach ($this->fTests as $test) {
            if ($testResult->shouldStop()) {
                break;
            }
            $test->run($testResult);
        }
    }

    public function countTestCases() {
        $count = 0;
        foreach ($this->fTests as $test) {
            $count += $test->countTestCases();
        }
        return $count;
    }
}

/**
 * TestFailure class to record a single test failure.
 */
class TestFailure {
    private $fFailedTestName;
    private $fExceptions;

    public function __construct($test, $exceptions) {
        $this->fFailedTestName = $test->name();
        $this->fExceptions = $exceptions;
    }

    public function getExceptions() {
        return $this->fExceptions;
    }

    public function getTestName() {
        return $this->fFailedTestName;
    }
}

/**
 * TestResult class to collect and report test results.
 */
class TestResult {
    private $fFailures = [];
    private $fRunTests = 0;
    private $fStop = false;

    public function run($test) {
        $this->fRunTests++;
        $test->runBare();
        $exceptions = $test->getExceptions();
        if ($exceptions) {
            $this->fFailures[] = new TestFailure($test, $exceptions);
        }
    }

    public function countTests() {
        return $this->fRunTests;
    }

    public function shouldStop() {
        return $this->fStop;
    }

    public function stop() {
        $this->fStop = true;
    }

    public function countFailures() {
        return count($this->fFailures);
    }

    public function getFailures() {
        return $this->fFailures;
    }
}

/**
 * Specialized TestResult for text reporting.
 */
class TextTestResult extends TestResult {
    public function report() {
        $nRun = $this->countTests();
        $nFailures = $this->countFailures();

        echo "<p>$nRun test(s) run<br>";
        echo "$nFailures failure(s).<br>";

        if ($nFailures > 0) {
            echo "<ol>";
            foreach ($this->getFailures() as $failure) {
                echo "<li>" . htmlspecialchars($failure->getTestName()) . "<ul>";
                foreach ($failure->getExceptions() as $exception) {
                    echo "<li>" . htmlspecialchars($exception->getMessage()) . "</li>";
                }
                echo "</ul></li>";
            }
            echo "</ol>";
        }
    }
}

/**
 * TestRunner class to run a suite of tests and report results.
 */
class TestRunner {
    public function run($suite) {
        $result = new TextTestResult();
        $suite->run($result);
        $result->report();
    }
}
?>

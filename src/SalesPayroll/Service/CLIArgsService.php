<?php declare(strict_types = 1);

namespace SalesPayroll\Service;

final class CLIArgsService implements CLIArgsServiceInterface
{
    public function getArgs(): array
    {
        $argv = $_SERVER['argv'];
        array_shift($argv);

        $defaultValue = null;
        $result = [];

        for ($i = 0, $j = count($argv); $i < $j; $i++) {
            $arg = $argv[$i];

            if (substr($arg, 0, 2) === '--') { // --foo --bar=baz
                $equalPos = strpos($arg, '=');

                if ($equalPos === false) { // --foo
                    $key = substr($arg, 2);

                    if ($i + 1 < $j && $argv[$i + 1][0] !== '-') { // --foo value
                        $value = $argv[$i + 1];
                        $i++;
                    } else {
                        $value = $result[$key] ?? $defaultValue;
                    }

                    $result[$key] = $value;
                } else { // --bar=baz
                    $key = substr($arg, 2, $equalPos - 2);
                    $value = substr($arg, $equalPos + 1);
                    $result[$key] = $value;
                }
            } elseif (substr($arg, 0, 1) === '-') { // -k=value -abc
                if (substr($arg, 2, 1) === '=') { // -k=value
                    $key = substr($arg, 1, 1);
                    $value = substr($arg, 3);
                    $result[$key] = $value;
                } else { // -abc
                    $chars = str_split(substr($arg, 1));

                    foreach ($chars as $char) {
                        $key = $char;
                        $value = $result[$key] ?? $defaultValue;
                        $result[$key] = $value;
                    }

                    if ($i + 1 < $j && $argv[$i + 1][0] !== '-') { // -a value1 -abc value2
                        $result[$key] = $argv[$i + 1];
                        $i++;
                    }
                }
            } else { // plain arg
                $value = $arg;
                $result[] = $value;
            }
        }

        return $result;
    }
}

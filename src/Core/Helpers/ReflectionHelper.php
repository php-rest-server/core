<?php
/**
 * Created by PhpStorm.
 * User: bllem
 * Date: 02.08.17
 * Time: 22:05
 */

namespace RestCore\Core\Helpers;


class ReflectionHelper
{
    /**
     * @param \stdClass $class
     * @param $method
     * @return array
     */
    public static function getMethodInfo($class, $method)
    {
        $reflectionMethod = new \ReflectionMethod($class, $method);

        $params = $reflectionMethod->getParameters();

        $doc = static::processPHPDoc($reflectionMethod);

        return $doc;
    }

    public static function processPHPDoc(\ReflectionMethod $reflect)
    {
        $phpDoc = array('parameters' => array(), /*'return' => null,*/ 'description' => []);
        $docComment = $reflect->getDocComment();
        if (trim($docComment) == '') {
            return null;
        }
        $docComment = preg_replace('#[ \t]*(?:\/\*\*|\*\/|\*)?[ ]{0,1}(.*)?#', '$1', $docComment);
        $docComment = ltrim($docComment, "\r\n");
        $parsedDocComment = $docComment;
        $lineNumber = $firstBlandLineEncountered = 0;
        while (($newlinePos = strpos($parsedDocComment, "\n")) !== false) {
            $lineNumber++;
            $line = substr($parsedDocComment, 0, $newlinePos);

            $matches = array();
            if ((strpos($line, '@') === 0) && (preg_match('#^(@\w+.*?)(\n)(?:@|\r?\n|$)#s', $parsedDocComment, $matches))) {
                $tagDocblockLine = $matches[1];
                $matches2 = array();

                if (!preg_match('#^@(\w+)(\s|$)#', $tagDocblockLine, $matches2)) {
                    break;
                }
                $matches3 = array();
                if (!preg_match('#^@(\w+)\s+([\w|\\\]+)(?:\s+(\$\S+))?(?:\s+(.*))?#s', $tagDocblockLine, $matches3)) {
                    break;
                }
                if ($matches3[1] != 'param') {
                    /*if (strtolower($matches3[1]) == 'return') {
                        $phpDoc['return'] = array('type' => $matches3[2]);
                    }*/
                } else {
                    $name = $matches3[3];
                    if ($name[0] === '$') {
                        $name = substr($name, 1);
                    }
                    $phpDoc['parameters'][$name] = array('type' => $matches3[2], 'description' => $matches3[4]);
                }

                $parsedDocComment = str_replace($matches[1] . $matches[2], '', $parsedDocComment);
            } else {
                $phpDoc['description'][] = $line;
                $parsedDocComment = substr($parsedDocComment, $newlinePos+1);
            }
        }
        $phpDoc['description'] = trim(implode(' ', $phpDoc['description']));
        return $phpDoc;
    }
}

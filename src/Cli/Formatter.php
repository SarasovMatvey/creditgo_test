<?php

namespace App\Cli;

class Formatter
{
    protected const COLOR_GREEN = "\033[32m";
    protected const COLOR_LIGHT_GREEN = "\033[36m";
    protected const COLOR_OFF = "\033[0m";

    public function format(int $iterationsCount, array $documents): string {
        $K = 'strval'; // need to use const interpolation

        $documentsAsString = '';
        $currentColor = self::COLOR_GREEN;
        $nextColor = self::COLOR_LIGHT_GREEN;
        foreach ($documents as $document) {
            $documentAsString = var_export($document, true);
            $documentsAsString .= "\n${currentColor}${documentAsString}{$K(self::COLOR_OFF)}\n";
            list($currentColor, $nextColor) = [$nextColor, $currentColor];
        }

        return
<<<EOF

----------------------
Documents: 
${documentsAsString}
IterationsCount: {$K(self::COLOR_GREEN)}${iterationsCount}{$K(self::COLOR_OFF)}
----------------------

EOF;

    }
}
<?php
/**
 * URL Helper
 * User: TrinhNV
 * Date: 8/24/2018
 * Time: 3:55 PM
 */

namespace App\Helpers;

use App\Facades\StringFacade;

class TranscriptHelper
{
    const SUBTIME = 1;

    /**
     * GET transcript from xml
     *
     * @param $xml
     *
     * @return array
     */
    public static function readFromXML($xml)
    {
        $results = [];
        foreach ($xml->children() as $child) {
            $text = (string)$child;
            if (!empty($text))
                $results[] = [
                    'start' => (int)$child['start'],
                    'duration' => (int)$child['dur'],
                    'text' => $text
                ];
        }

        return $results;
    }

    /**
     * @param array  $transcripts
     * @param string $keyword
     * @param string $lang
     *
     * @return int
     */
    public static function getStartTime(&$transcripts, $keyword, $lang)
    {
        $lang = $lang ?? LANG_JP;
        if (!empty($transcripts) && is_array($transcripts) && $keyword) {
            $keyword = strtolower($keyword);

            foreach ($transcripts as &$transcript) {
                $transcript['rank'] = self::getTextRank($transcript, $keyword, $lang);
            }
        }
        $cTranscripts = (array)(clone (object)$transcripts);

        usort($cTranscripts, function ($item1, $item2) {
            return $item1['rank'] <= $item2['rank'];
        });

        if (!empty($cTranscripts) && $cTranscripts[0]['rank'] > 0) {
            $result = $cTranscripts[0]['start'] ?? 0;
            if ($result > self::SUBTIME) {
                $result -= self::SUBTIME;
            }
            return $result;
        }
        return NO_TRANSCRIPT_FOUND;
    }

    /**
     * @param string $transcript
     * @param string $keyword
     * @param string $lang
     *
     * @return float|int
     */
    private static function getTextRank(&$transcript, $keyword, $lang = LANG_JP)
    {
        mb_internal_encoding('UTF-8');
        mb_regex_encoding('UTF-8');

        $string = $transcript['text'];
        //remove new line
        $string = trim(preg_replace('/\s+/', '', $string));

//        $keyword = mb_convert_encoding($keyword, 'UTF-8');

        //keep words only
        if (StringFacade::checkContain($string, $keyword)) {
            //highest rank
            return 100;
        } else {
//            $stringCheck = $string;//StringFacade::encode_numericentity($string);
            $wordLength = str_word_count($keyword);
            if ($wordLength) {
                $totalFound = 0;
                for ($i = 0; $i < $wordLength; $i++) {
//                dd(strpos($stringCheck, StringFacade::encode_numericentity($keyword{$i})));
//                dd(StringFacade::checkContain($stringCheck, StringFacade::encode_numericentity($keyword{$i})));
//                $word = $keyword{$i};//StringFacade::encode_numericentity($keyword{$i});
                    $word = mb_substr($keyword, $i, $i + 1);
                    if (empty($word) && $lang != LANG_JP) continue;
                    if (StringFacade::checkContain($string, $word)) {
                        $totalFound++;
                    }
                }
                return $totalFound / $wordLength * 100;
            }
        }


        return 0;
    }

}

<?php

namespace App\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @method static array readFromXML($xml)
 * @method static integer getStartTime(&$transcripts, $keyword, $lang)
 *
 * @see \App\Helpers\TranscriptHelper
 */
class TranscriptFacade extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'transcript_helper';
    }
}

<?php

namespace App\Console\Commands;

use App\Api\CountryApiService;
use Illuminate\Console\Command;

const SAME_LANGUAGE = 'These countries speak the same language.';
const DIFFERENT_LANGUAGE = 'These countries does not speak the same language.';
const INVALID_INPUT = 'Your Input Is Invalid. Please Check Your Input.';
const LANGUAGE_ONE_COUNTRY = 'This Language Is Only Speaking By ';
const LANGUAGE_DIFFERENT_COUNTRY = ' speaks same language with these countries:';
class CountryDetector extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'country:detect {country*}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command that will list all the countries 
                              which speaks the same language or
                              checks if given two countries speak the
                              same language by using restcountries api:';

    /**
     * @var CountryApiService
     */
    protected $apiService;

    /**
     * CountryDetector constructor.
     *
     * @param CountryApiService $apiService
     */
    public function __construct(CountryApiService $apiService)
    {
        parent::__construct();
        $this->apiService = $apiService;

    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $arguments = $this->arguments();
        $countries = $arguments['country'];

        if (!$this->apiService->isValidated($countries)) {
            $this->error(INVALID_INPUT);
            exit(1);
        }

        /**
         * If length is 1 the command lists the all countries which speaks the same language
         */
        if (count($countries) == 1) {
            $languageCodes = $this->apiService->getLanguageCodeByName($countries[0]);
            $this->info(
                'Country Language Code: '
                . implode(',', $languageCodes) . PHP_EOL
            );

            $sameCountries = $this->apiService->getNamesWithSameLanguageCode($countries);
            return empty($sameCountries)
                ?
                $this->info( LANGUAGE_ONE_COUNTRY . ucfirst($countries[0]))
                :
                $this->info(
                    ucfirst($countries[0]) . LANGUAGE_DIFFERENT_COUNTRY
                    . PHP_EOL . implode(',', $sameCountries)
                );
        } else {
            return $this->apiService->hasCommonLanguageCodeByName($countries)
                ?
                $this->info(SAME_LANGUAGE)
                :
                $this->info(DIFFERENT_LANGUAGE);
        }

    }
}

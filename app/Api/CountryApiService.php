<?php

namespace App\Api;

const NOT_FOUND = 404;
class CountryApiService implements CountryApiServiceInterface
{
    /**
     * @var LanguageCodeCallAdapter
     */
    private $_languageCodeAdapter;

    /**
     * @var StateInfoCallAdapter
     */
    private $_stateInfoAdapter;

    /**
     * Country constructor.
     *
     * @param LanguageCodeCallAdapter $codeCallAdapter
     * @param StateInfoCallAdapter $stateInfoCallAdapter
     */
    public function __construct(LanguageCodeCallAdapter $codeCallAdapter,
                                StateInfoCallAdapter $stateInfoCallAdapter
    )
    {
        $this->_languageCodeAdapter = $codeCallAdapter;
        $this->_stateInfoAdapter = $stateInfoCallAdapter;
    }

    /**
     * @param  $countryNames
     * @return array
     */
    public function getNamesWithSameLanguageCode($countryNames): array
    {
        $result = [];
        $fullName = $this->getFullName($countryNames);
        foreach ($countryNames as $name) {
            $codes = $this->getLanguageCodeByName($name);
            foreach ($codes as $code) {
                $response = $this->_languageCodeAdapter->call($code);
                foreach ($response as $language) {
                    $result[] = $language['name'];
                }
            }
        }

        sort($result);
        return array_diff($result, $fullName);
    }

    /**
     * @param  $countryName
     * @return array
     */
    public function getFullName($countryName): array
    {
        $result = [];
        foreach ($countryName as $name) {
            $response = $this->_stateInfoAdapter->call($name);
            foreach ($response as $value) {
                $result[] = $value['name'];

            }
        }
        return $result;
    }

    /**
     * @param  $countryName
     * @return array
     */
    public function getLanguageCodeByName($countryName): array
    {
        $countryInformationParams = $this->_stateInfoAdapter->call($countryName);
        foreach ($countryInformationParams as $parameters) {
            foreach ($parameters['languages'] as $param) {
                $code[] = $param['iso639_1'];
            }
        }

        sort($code);
        return $code;
    }

    /**
     * @param  $countryNames
     * @return bool
     */
    public function hasCommonLanguageCodeByName($countryNames): bool
    {
        $code = [];
        foreach ($countryNames as $countryName) {
            $code[] = $this->getLanguageCodeByName($countryName);
        }

        return !empty(array_intersect($code[0], $code[1]));
    }

    /**
     * @param  $countryNames
     * @return bool
     */
    public function isValidated($countryNames): bool
    {
        $result = [];
        foreach ($countryNames as $countryName) {
            $result[] = $this->_stateInfoAdapter->call($countryName);
        }

        return (in_array(NOT_FOUND, $result)) ? false : true;
    }

}

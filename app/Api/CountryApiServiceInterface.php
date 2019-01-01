<?php


namespace App\Api;


interface CountryApiServiceInterface
{
    public function getNamesWithSameLanguageCode($countryName);

    public function getLanguageCodeByName($countryName);

    public function isValidated($countryNames);

    public function hasCommonLanguageCodeByName($countryNames);

    public function getFullName($countryNames);
}
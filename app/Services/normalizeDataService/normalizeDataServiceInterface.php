<?php

namespace App\Services\normalizeDataService;

interface normalizeDataServiceInterface{
    public function __construct($request);
    public function getData() : array;
}
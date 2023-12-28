<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client as GuzzleClient;
use App\Models\{
    State,
    City
};

class IBGEController extends Controller
{
    private $httpClient;

    function __construct() {
        $this->httpClient = new GuzzleClient([
            'base_uri' => 'https://servicodados.ibge.gov.br/api/v1/',
            'verify' => false
        ]);
    }

    public function states() {
        $statesStream = $this->httpClient->request('GET', 'localidades/estados?orderBy=nome', []);

        if($statesStream->getStatusCode() !== 200) {
            return null;
        }

        $states = json_decode($statesStream->getBody()->getContents());

        State::query()->delete();

        foreach($states as $s) {
            $state = new State;

            $state->initials = $s->sigla;
            $state->description = $s->nome;

            $state->save();
        }

        return $states;
    }

    public function cities($stateInitials) {
        $citiesStream = $this->httpClient->request('GET', 'localidades/estados/'.$stateInitials.'/municipios?orderBy=nome', []);

        if($citiesStream->getStatusCode() !== 200) {
            return null;
        }

        $state = State::firstWhere('initials', $stateInitials);
        $cities = json_decode($citiesStream->getBody()->getContents());

        foreach($cities as $c) {
            $city = new City;

            $city->code = $c->id;
            $city->description = $c->nome;
            $city->state_id = $state->id;

            $city->save();
        }

        return $cities;
    }
}

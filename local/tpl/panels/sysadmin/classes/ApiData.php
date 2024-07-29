<?php


class ApiData
{

    private $services = [];

    function getSOInfo($host)
    {
        try {
            $client = new GuzzleHttp\Client();
            $response = $client->request('GET', 'https://' . $host . ':7475/api/v1/server/so-info/');
            $result = json_decode($response->getBody()->getContents(), true);
        } catch (Exception $e) {

        }

        return $result['data'];
    }

    function getServices($host)
    {
        try {
            $client = new GuzzleHttp\Client();
            $response = $client->request('GET', 'https://' . $host . ':7475/api/v1/server/services-status/');
            $result = json_decode($response->getBody()->getContents(), true);
        } catch (Exception $e) {

        }

        return $result['data'];
    }

    function getDiskInfo($host, $mount_point)
    {
        try {
            $client = new GuzzleHttp\Client();
            $response = $client->request('GET', 'https://' . $host . ':7475/api/v1/server/disk-info/' . $mount_point);
            $result = json_decode($response->getBody()->getContents(), true);
        } catch (Exception $e) {

        }

        return $result['data'];
    }

    function getMemoryInfo($host)
    {

        try {
            $client = new GuzzleHttp\Client();
            $response = $client->request('GET', 'https://' . $host . ':7475/api/v1/server/get-system-mem-info');
            $result = json_decode($response->getBody()->getContents(), true);
        } catch (Exception $e) {

        }

        return $result['data'];
    }

}

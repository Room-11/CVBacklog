<?php namespace com\github\gooh\CVBacklog;
class Client
{
    /**
     * @var Url
     */
    protected $endpoint;

    /**
     * @param Url $endpoint
     */
    public function __construct(Url $endpoint)
    {
        $this->endpoint = $endpoint;
    }

    /**
     * @param array $ids
     * @return array
     */
    public function findByIds(array $ids)
    {
        $data = array();
        foreach (array_chunk($ids, 100) as $i => $batch) {
            $result = $this->executeRequest($this->formatEndpoint($batch));
            if (isset($result->items)) {
                $data = array_merge($data, $result->items);
            } else {
                error_log("Error fetching batch $i: " . var_export($result, true));
            }
        }
        return $data;
    }

    /**
     * @param string $url
     * @return array
     */
    protected function executeRequest($url)
    {
        stream_context_set_option(
            stream_context_get_default(),
            'http',
            'header',
            'Accept-Encoding: gzip, deflate'
        );
        $data = json_decode(file_get_contents($url));
        return $data === null ? array() : $data;
    }

    /**
     * @param array $ids
     * @return string
     */
    protected function formatEndpoint(array $ids) {
        return  'compress.zlib://' . sprintf(
            urldecode($this->endpoint),
            implode(';', $ids)
        );
    }
}
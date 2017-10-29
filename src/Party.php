<?php
    namespace Mintopia\EpicMusic;
    
    use GuzzleHttp\Client;
    
    class Party
    {
        
        protected $id;
        protected $endpoint;
        protected $apiKey;
        
        public function setParty($id)
        {
            $this->id = $id;
        }

        public function setApiKey($key)
        {
            $this->apiKey = $key;
        }

        public function setEndpoint($endpoint)
        {
            $this->endpoint = $endpoint;
        }
        
        public function next()
        {
        }
        
        public function getStatus()
        {
            $result = $this->get("/v1/parties/{$this->id}");
            return new Status($this, $result->data);
        }
        
        public function getQueue()
        {
            $return = [];
            $page = 1;
            do {
                $result = $this->get("/v1/parties/{$this->id}/tracks?per_page=100&page={$page}");
                $page++;
                foreach ($result->data as $data) {
                    $return[] = new Track($this, $data);
                }
            } while ($result->links->next !== null);
            return $return;
        }

        public function vote($spotifyId, $source)
        {
            $data = (object) [
            	'track' => $spotifyId,
                'source' => $source
            ];
            $result = $this->post("/v1/parties/{$this->id}/tracks", $data);
            return new Track($this, $result->data);
        }
        
        public function get($url, $params = [])
        {
            $args = [];
            if ($params) {
                $args['query'] = $params;
            }
          
            return $this->makeRequest('GET', $url, $args);
        }
        
        public function post($url, $data)
        {
            $args = [];
            if ($data) {
                $args['json'] = $data;
            }
            return $this->makeRequest('POST', $url, $args);
        }
        
        protected function makeRequest($method, $url, $params = [])
        {
            if (isset($params['headers'])) {
                $params['headers'] = [];
            }
            $params['headers']['Authorization'] = "Bearer {$this->apiKey}";

            $fullUrl = $this->endpoint . $url;
            $client = new Client;
            $response = $client->request($method, $fullUrl, $params);
            return json_decode($response->getBody());
        }
    }
    
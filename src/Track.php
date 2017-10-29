<?php
    namespace Mintopia\EpicMusic;
    
    class Track
    {
        public $name;
        public $track_uri;
        public $votes = 0;
        public $queued = false;
        public $party;
        
        public function __construct($party, $data = null)
        {
            $this->party = $party;

            $this->populateFromData($data);
        }
        
        public function populateFromData($data)
        {
            if (!$data) {
                return;
            }
            
            $this->name = $data->name;
            $this->track_uri = $data->track_uri;
            $this->votes = (int) $data->votes;
            $this->queued = (bool) $data->queued;
        }
        
        public function vote($source)
        {
            return $this->party->vote($this->track_uri, $source);
        }
    }
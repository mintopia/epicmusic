<?php
    namespace Mintopia\EpicMusic;
    
    use Carbon\Carbon;
    
    class Status
    {
        public $name;
        public $active = false;
        public $code;
        public $playlist_uri;
        public $backup_playlist_uri;
        public $track_uri;
        public $track_started_at;
        public $track_ends_at;
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
            $this->active = (bool) $data->active;
            $this->code = $data->code;
            $this->track_uri = $data->track_uri;
            $this->playlist_uri = $data->playlist_uri;
            $this->backup_playlist_uri = $data->backup_playlist_uri;
            $this->track_started_at = $data->track_started_at ? new Carbon($data->track_started_at) : null;
            $this->track_ends_at = $data->track_ends_at ? new Carbon($data->track_ends_at) : null;
        }
    }
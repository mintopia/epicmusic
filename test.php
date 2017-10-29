<?php
    require_once('vendor/autoload.php');
    
    use Mintopia\EpicMusic\Party;
    
    $party = new Party();
    $party->setEndpoint('https://music.orion.42m.co.uk/api');
    $party->setApiKey('YOUR KEY HERE');
    $party->setParty(1);

    $status = $party->getStatus();
    print_r($status);
    
    $queue = $party->getQueue();
    
    foreach ($queue as $track) {
        echo str_pad($track->name, 60);
        echo str_pad($track->votes, 4);
        echo $track->queued ? 'Queued' : '';
        echo "\r\n";
    }

    echo "\r\nAdding vote to first non queued track";
    foreach ($queue as $track) {
        if ($track->queued) {
            continue;
        }
        echo "\r\nVoting for {$track->name}\r\n\r\n";
        $track->vote('Test Vote ' . time());
        break;
    }
    
    $queue = $party->getQueue();
    
    foreach ($queue as $track) {
        echo str_pad($track->name, 60);
        echo str_pad($track->votes, 4);
        echo $track->queued ? 'Queued' : '';
        echo "\r\n";
    }


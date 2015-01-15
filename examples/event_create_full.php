<?php
require_once __DIR__.'/../src/Attendly.php';

// Get username and key from ENV variables, they could be hard coded or from a
// config file - etc.
$user = getenv('ATTENDLY_API_USER');
$key = getenv('ATTENDLY_API_KEY');

// Get an instance of the API
$attendly = new \Attendly\Attendly($user, $key);

// Create an event with all the event attributes
$event = array(
	'Name' => 'Test event via API',
	'Description' => '<p>This is just a test event. Note <strong>HTML</strong>strong></p>p>',
	'PresentedBy' => 'Attendly test',
	'NotAvailableMessage' => 'This event is not available anymore',
	'ThanksMessage' => 'Thanks for registering',
	'EmailMessage' => 'Thanks for registering',
	'FooterText' => 'See you there!',
	'ShowDetails' => true,
	'ShowComments' => false,
	'ShowSocialMedia' => true,
	'ShowDeadline' => true,
	'AttachTicket' => true,
	'Deadline' => '2015-11-07T23:00:00Z',
	'Start' => '2015-11-10T23:00:00Z',
	'Stop' => '2015-11-10T23:00:00Z',
	'ActiveStart' => '2000-01-01T23:00:00Z',
	'Terms' => 'Please accept these extra terms',
	'PushURL' => 'http://localhost/push/here',
	'Subdomain' => 'attendlytest',
	'ReturnURL' => 'http://www.attendly.com',
	'Hashtag' => 'test',
	'Currency' => 'USD',
	'Password' => 'letmein',
	'Status' => 'active',
);

$ticket_1 = array(
	'Name' => 'Test ticket number one',
	'Description' => 'General ticket',
	'Message' => 'See you on the day',
	'Price' => 0,
	'Total' => 1000,
	'Earlybird' => false,
	'EarlybirdPrice' => 0,
	'EarlybirdDate' => '2000-01-01T23:00:00Z',
	'EarlybirdExpiryShow' => false,
	'DefaultQuantity' => 10,
	'Order' => 1,
	'Status' => 'active',
);

$ticket_2 = array(
	'Name' => 'Test ticket number two',
	'Description' => 'General ticket two',
	'Message' => 'See you on the day',
	'Price' => 0,
	'Total' => 2000,
	'Earlybird' => false,
	'EarlybirdPrice' => 0,
	'EarlybirdDate' => '2000-01-01T23:00:00Z',
	'EarlybirdExpiryShow' => false,
	'DefaultQuantity' => 10,
	'Order' => 2,
	'Status' => 'active',
);

$text_widget = array(
	'Name' => 'Test widget one',
	'Description' => 'Just a widget',
	'Label' => 'A test label',
	'Order' => 1,
	'Type' => 'text',
	'Status' => 'active',
);

$textarea_widget = array(
	'Name' => 'Test widget two',
	'Description' => 'General',
	'label' => 'A test textarea',
	'Order' => 2,
	'Type' => 'textarea',
	'Status' => 'active',
);

$address = array(
    'Name' => 'Test address',
    'Line1' => '100 Collins Street',
    'City' => 'Melbourne',
    'Post' => '3000',
    'State' => 'VIICTORIA',
    'Country' => 'Australia',
    'Status' => 'active',
);

$result = $attendly
    ->add_event($event)
    ->add_ticket($ticket_1)
    ->add_ticket($ticket_2)
    ->add_ticket_limit(2000)
    //->add_widget($text_widget)
    //->add_widget($textarea_widget)
    //->add_address($address)
    ->event_create();

var_dump($result);

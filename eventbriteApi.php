<?php

$token = '7UJ63S6RAJZFUSFSUXFG';

$orgID = '1061056997603';

$result = file_get_contents("https://www.eventbriteapi.com/v3/organizations/$orgID/events/?token=$token&expand=venue");

$res = json_decode($result, true);

// echo "<pre>";
// var_dump($res);

function checkVenue($venuData){
   return isset($venuData["venue"]) && isset($venuData["venue"]["address"]); 
}

$output = "";
if(count($res["events"]) > 0 ){
    
    
    foreach ($res["events"] as $event) {
       $id = $event["id"];
       $title = $event["name"]["html"];
       $description = $event["description"]["html"];
       $eventURL = $event["url"];
       $location = checkVenue($event) ? $event["venue"]["address"]["city"] : null;

    //    echo $description;

    $output .= "<h2><a href='$eventURL'>$title</a></h2>";
    $output .= "<p>$description</p>";
    $output .= "<h2>$location</h2>";
    $output .= "<button id='example-widget-trigger-$id' type='button'>Buy Tickets</button>";
$output .= "
<script>
window.EBWidgets.createWidget({
    widgetType: 'checkout',
    eventId: '$id',
    modal: true,
    modalTriggerElementId: 'example-widget-trigger-$id',
    onOrderComplete: () => {
        console.log('haii')
    },
});
</script>
";        
    }

}
// $output .= `<script type="text/javascript">
//     var exampleCallback = function () {
//         console.log('Order complete!');
//     };
// </script>`;
echo $output;
?>
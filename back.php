<!DOCTYPE html>
<html>
    <head>
        <title>Result</title>
        <style>
         ::-webkit-scrollbar {
            width: 15px;
          }
          
          /* Track */
          ::-webkit-scrollbar-track {
            background: #464444; 
            border-radius: 50px;
          }
          
          /* Handle */
          ::-webkit-scrollbar-thumb {
            background: rgb(160, 87, 219); 
            border-radius: 50px;
          }
          
          /* Handle on hover */
          ::-webkit-scrollbar-thumb:hover {
            background: rgb(190, 188, 188); 
          }

        *{
            background-color: black;
        }
        body {
          font-family: Helvetica;
          margin: 0;
          background-color: black;
        }
        div{
          width: 100%;
          background-color: #212121 !important;
          border-radius: 20px;
        }
        a{
          background-color: transparent !important;
          text-decoration: none;
          color: white;
          font-size: 30px
        }
        ul{
          background-color: transparent !important;
          text-decoration: none;
        }
        li{
          background-color: transparent !important;
          display: inline-block;
          vertical-align: middle;
          margin: 0px;
          padding: 0;
        }
        img{
          height: 150px;
          width: 100px;
          margin: 0px;
          padding: 0;
          margin-top: 10px
        }
        .name{
          margin: 50px;
        }
        .genre{
          float: right;
          margin-top: 60px;
          margin-right: 100px;
          font-size: 20px;
        }
        .noRes{
          color: white;
          font-size: 100px;
          text-align: center;
          position: relative;
          top: 200px;
        }
        </style>
    </head>
    <body>
    <?php
if(isset($_POST['submit'])){
   $genre = $_POST['genre'];
   $platform = $_POST['platform'];
   $player_perspective = $_POST['pp'];


$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => 'https://api.igdb.com/v4/games/',
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => 'POST',
  CURLOPT_POSTFIELDS =>'fields name,genres.name, cover.url, websites.url, player_perspectives.name, platforms.name; where genres = '.$genre.' & platforms = '.$platform.'  & player_perspectives = '.$player_perspective.'; limit 500;
',
  CURLOPT_HTTPHEADER => array(
    'Client-ID: YOUR_CLIENT_ID',
    'Authorization: Bearer YOUR_AUTHORIZATION_TOKEN',
    'Content-Type: text/plain'
  ),
));

$response = curl_exec($curl);

$gameData = json_decode($response, true);
if(empty($gameData)){
  echo '<p class="noRes">404 : No Results Found</p>';
}
curl_close($curl);

foreach ($gameData as $gameRes) {
    
    if(empty($gameRes['cover'])){
      $cover_url = "#";
    }
    else{
      $cover_url = $gameRes['cover']['url'];
    }

    if(empty($gameRes['websites'])){
      $web_url = "#";
    }
    else{
      $web_url = $gameRes['websites'][0]['url'];
    }


    echo '<div class="list">
    <a target="_blank" href="'.$web_url.'">
      <ul>
        <li><img src="'.str_replace("t_thumb","t_cover_big",$cover_url).'" alt=""></li>
        <li class="name">'.$gameRes['name'].'</li>
        <li class="genre">Genre : '.$gameRes['genres'][0]['name'].'</li>
      </ul>
    </a>
  </div>';


}
}
?>
    </body>
</html>

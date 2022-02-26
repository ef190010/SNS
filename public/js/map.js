var marker;

function initMap() {

    // マップの初期化
    var map = new google.maps.Map(document.getElementById('map'), {
        zoom: 10,
        center: {lat: 35.6809591, lng: 139.7673068}
    });

    // クリックイベントを追加
    map.addListener('click', function(e) {
        getClickLatLng(e.latLng, map);
    });
}

function getClickLatLng(lat_lng, map) {

    // 座標を表示
    // var lat = lat_lng.lat();
    // var lng = lat_lng.lng();
    
    document.getElementById('lat').value = lat_lng.lat();
    document.getElementById('lng').value = lat_lng.lng();

    // マーカーを設置
    if (marker) {
        marker.setMap(null);
    }
    marker = new google.maps.Marker({
        position: lat_lng,
        map: map
    });
}

function deleteMarker() {
    marker.setMap(null);
    marker = null;
    document.getElementById('lat').value = null;
    document.getElementById('lng').value = null;
}

function showMap() {
    var lat = Number(document.getElementById('js-getLat').dataset.name);
    var lng = Number(document.getElementById('js-getLng').dataset.name);
    // console.log(typeof(lat));
    // マップの初期化
    var point = {lat: lat, lng: lng}
    var map = new google.maps.Map(document.getElementById('map'), {
        zoom: 13,
        center: point,
    });
    
    marker = new google.maps.Marker({
        // ピンを差す位置を決めます。
        position: point,
	    // ピンを差すマップを決めます。
        map: map,
	    // ホバーしたときに「」と表示されるようにします。
        // title: '',    
    });    
}

function editMap() {
    var lat = Number(document.getElementById('js-getLat').dataset.name);
    var lng = Number(document.getElementById('js-getLng').dataset.name);
    // console.log(typeof(lat));
    // マップの初期化
    var point = {lat: lat, lng: lng}
    var map = new google.maps.Map(document.getElementById('map'), {
        zoom: 13,
        center: point,
    });
    
    marker = new google.maps.Marker({
        // ピンを差す位置を決めます。
        position: point,
	    // ピンを差すマップを決めます。
        map: map,
	    // ホバーしたときに「」と表示されるようにします。
        // title: '',    
    });    

    // クリックイベントを追加
    map.addListener('click', function(e) {
        getClickLatLng(e.latLng, map);
    });
    
}
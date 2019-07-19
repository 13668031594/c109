
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>NePublisher Demo</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <script src="//nos.netease.com/vod163/nePublisher.min.js"></script>
    <link rel="stylesheet" type="text/css" href="http://www.bootcss.com/p/buttons/css/buttons.css">
    <style type="text/css">
        .m-input {
            margin-bottom: 10px;
        }
        .u-input-name {
            display: inline-block;
            width: 85px;
        }
        .u-input {
            width: 500px;
            height: 25px;
            border: none;
            border-bottom: 1px solid #000;
            outline: none;
            color: #000;
        }
        .testBtn {
            width: 150px;
        }
        .u-status {
            margin-left: 10px;
            display: inline-block;
        }
    </style>
</head>
<body>
<h1>NePublisher Demo</h1>
<div class="m-input">
    <span class="u-input-name">摄像头：</span>
    <select class="u-input" id="cameraSelect">
    </select>
</div>
<div class="m-input">
    <span class="u-input-name">麦克风：</span>
    <select class="u-input" id="microPhoneSelect">
    </select>
</div>
<div class="m-input">
    <span class="u-input-name">清晰度：</span>
    <select class="u-input" id="qualitySelect">
        <option value="0">流畅（480*360@20）</option>
        <option value="1">标清（640*480@20）</option>
        <option value="2">高清（960*540@20）</option>
    </select>
</div>
<div class="m-input">
    <span class="u-input-name">推流地址：</span>
    <input class="u-input" type="text" id="publishUrl">
</div>
<div class="m-input">
    <button class="button button-primary button-rounded testBtn" id="previewBtn" onclick="startPreview()">预览</button>
    <button class="button button-primary button-rounded testBtn" id="publishBtn" onclick="startPublish()">开始直播</button>
    <span class="u-status"></span>
</div>
<div id="my-publisher"></div>
<script type="text/javascript">
    var cameraList,
        microPhoneList,
        cameraOptions = '',
        microPhoneOptions = '';
    var publishBtn = document.getElementById('publishBtn');
    var previewBtn = document.getElementById('previewBtn')
    var testInput = document.getElementsByClassName('u-input');
    var myPublisher = new nePublisher('my-publisher', {
        //viewOptions
        videoWidth: 960,
        videoHeight: 540,
        fps: 20,
        bitrate: 1500
    }, {
        //flashOptions
        previewWindowWidth: 862,
        previewWindowHeight: 486,
        wmode: 'transparent',
        quality: 'high',
        allowScriptAccess: 'always'
    }, function() {
        cameraList = this.getCameraList();
        microPhoneList = this.getMicroPhoneList();
        console.log(cameraList, microPhoneList);
        for (var i = cameraList.length - 1; i >= 0; i--) {
            cameraOptions = '<option value="' + i + '">' + cameraList[i] + '</option>' + cameraOptions;
        }
        for (var i = microPhoneList.length - 1; i >= 0; i--) {
            microPhoneOptions = '<option value="' + i + '">' + microPhoneList[i] + '</option>' + microPhoneOptions;
        }
        document.getElementById("cameraSelect").innerHTML = cameraOptions;
        document.getElementById("microPhoneSelect").innerHTML = microPhoneOptions;
    }, function(code, desc) {
        console.log(code, desc);
    });
    var qualityList = [
        {
            //流畅
            fps: 20,
            bitrate: 600,
            videoWidth:480,
            videoHeight:360
        },
        {
            //标清
            fps: 20,
            bitrate: 800,
            videoWidth:640,
            videoHeight:480
        },
        {
            //高清
            fps: 20,
            bitrate: 1500,
            videoWidth:960,
            videoHeight:540
        }
    ];
    var getCameraIndex = function() {
        var cameraSelect = document.getElementById("cameraSelect");
        var cameraIndex = cameraSelect.selectedIndex;
        return cameraSelect.options[cameraIndex].value;
    };
    var getMicroPhoneIndex = function() {
        var microPhoneSelect = document.getElementById("microPhoneSelect");
        var microPhoneIndex = microPhoneSelect.selectedIndex;
        return microPhoneSelect.options[microPhoneIndex].value;
    };
    var getQualityOption = function() {
        var qualitySelect = document.getElementById("qualitySelect");
        var qualityIndex = qualitySelect.selectedIndex;
        return qualityList[qualityIndex];
    };
    var startPreview = function() {
        myPublisher.startPreview(getCameraIndex());
        document.getElementsByClassName('u-status')[0].innerHTML = '预览中';
    };
    var startPublish = function() {
        var publishUrl = document.getElementById("publishUrl").value;
        startPublishCall();
        myPublisher.setCamera(getCameraIndex());
        myPublisher.setMicroPhone(getMicroPhoneIndex());
        myPublisher.startPublish(publishUrl, getQualityOption(),function(code, desc) {
            console.log(code, desc);
            alert(code + '：' + desc);
            stopPublishCall();
        });
    };
    var stopPublish = function() {
        myPublisher.stopPublish();
        stopPublishCall();
    };
    var startPublishCall = function() {
        console.log('推流开始');
        document.getElementsByClassName('u-status')[0].innerHTML = '直播中';
        publishBtn.innerHTML = '停止直播';
        publishBtn.onclick = stopPublish;
        for (var i = testInput.length - 1; i >= 0; i--) {
            testInput[i].disabled = true;
        }
        previewBtn.disabled = true;

    };
    var stopPublishCall = function() {
        console.log('推流结束');
        document.getElementsByClassName('u-status')[0].innerHTML = '预览中';
        publishBtn.innerHTML = '开始直播';
        publishBtn.onclick = startPublish;
        for (var i = testInput.length - 1; i >= 0; i--) {
            testInput[i].disabled = false;
        }
        previewBtn.disabled = false;
    };
</script>
</body>
</html>

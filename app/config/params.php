<?php

// this contains the application parameters that can be maintained via GUI
return array(
// this is displayed in the header section
    'talkMsg'=>"{0}"."邀请你进入聊天室". "</a><a href=" . "\"/newbbs/chat/index?room_id=" . "{1}" . "_"."{2}" .
        "\">" . "点击进入" . "</a>",

    'acceptMsg'=> "你发布的任务：<a href=" . "\"/newbbs/reward/detail/" . "{0}" .
        "\">" . "{1}" . "</a>已经被<a href=" . "\"/newbbs/chat/index?room_id=" . "{2}" . "_"."{3}" .
        "&task_id="."{4}" . "\">" . "{5}" . "</a>受理。",

    'accepMsgSys'=> "任务：<a href=" . "\"/newbbs/reward/detail/" . "{0}".
    "\">" ."{1}". "</a>受理成功.<a href=" . "\"/newbbs/chat/index?room_id=" . "{2}" . "_"."{3}".
    "\">" . "  点击进入聊天室" . "</a>。",

    'publicMsg'=>  '你的预测任务,已经发布成功。预测任务名:<a href="/newbbs/reward/detail/' . "{0}" . '">' . "{1}" . '</a>',


);

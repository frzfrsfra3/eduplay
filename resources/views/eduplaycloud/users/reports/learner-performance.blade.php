<?php

    $userAvgData = $userAvgArr[0];

    if (isset($userAvgArr[0]) && !empty($userAvgArr[0])) {
        unset($userAvgArr[0]);
        $userAvgArr = array_values($userAvgArr);
    } else {
        $userAvgArr = [];
    }

    if (count($userAvgData) > 0) {


        ?>
        <div class="main-div">
            <div class="mn_ln" style="min-width: 700px !important">
                <div class="left_lerner">
                    <h3> {{ Lang::get("filter.learners") }}</h3>
                </div>
                <div class="right_avgrg">
                    <h3>{{ Lang::get("filter.average_performance") }}</h3>
                </div>
            </div>
        <?php

        $userIDs = "";
        for ($a=0; $a<count($userAvgData); $a++) {
            
            $scoreDataText = $userAvgArr[0][$a];
            
            $nameStr = $userAvgData[$a];
            $nameArr =  explode('|', $nameStr);

            if (isset($nameArr[0]) || !empty($nameArr[0])) {
                $name = $nameArr[0];
            } else {
                $name = '';
            }

            if (isset($nameArr[1]) || !empty($nameArr[1])) {
                $userId = $nameArr[1];
                $userIDs .= $userId . ",";
            } else {
                $userId = 0;
            }

            if (isset($nameArr[2]) || !empty($nameArr[2])) {
                $avg = $nameArr[2];
            } else {
                $avg = 0;
            } 

            $pageUrl = URL('reports/skill/performance/view/by/test/'.$classId.'/'.$userId);
            ?>
            <input type='hidden' class='user-performance-chart-item' value='{{ $scoreDataText }}' />
            <div class="mn_ln" style="min-width: 700px !important">
                <div class="left_lerner" style="width: 150px !important;margin:0 !important;padding:0 !important;">
                    <a href=" {{ $pageUrl }}"> {{ $name }}</a>
                </div>
                <div class="right_avgrg" style="min-width: 450px !important; padding-left: 0 !important;margin:0 !important;padding:0 !important;">
                    <span class="count_num d-inline-block" style="width:35px;margin:0 !important;padding:0 !important;">{{ $avg }}</span>
                    <div class="d-inline-block" id="user-performance-chart-{{ $a }}" style="margin:0 !important;padding:0 !important;"></div>
                </div>
            </div>
            <?php 
        }
        echo '</div>';
    } else {
        //echo '<div><img src="https://place-hold.it/522x434/eeeeee?text=Woops! Looks like there\'s no data.&fontsize=13" alt="Woops! Looks like there\'s no data."></div>';
        $url=url('assets/eduplaycloud/image');
        echo '<div><img src="'.$url.'/no_data_found.jpg" class="img-fluid" /></div>';
    }
?>
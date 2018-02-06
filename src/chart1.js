 //query database
        var userid = document.getElementById("userid").innerHTML;
        var brac = [];
        var time = [];
        var reason = [];
        var interval;

        var m = document.getElementById("month1");
        var month = m.options[m.selectedIndex].value;
        var w = document.getElementById("week1");
        var week = w.options[w.selectedIndex].value;

        var c0 = 1;
        var c1 = 1;
        var c2 = 1;
        var c3 = 1;
        var c4 = 1;
        var c5 = 1;
        var c6 = 1;
        var c7 = 1;
        var c8 = 1;
        var c9 = 1;

        $.ajax({
            type: 'post',
            url: 'get_brac_data.php',
            data: "userid="+ userid,
            dataType: 'json',
            async: false,
            success: function(response) {
            //here I'd like back the php query
                interval = response.length;
                for (var i = 0; i < interval; i++){
                    brac.push(response[i].brac);
                    time.push(response[i].time);
                    reason.push(response[i].reason);

                }
            }
        });
        document.getElementById('interval').innerHTML = interval;

        console.log(brac);

        var presets = window.chartColors;

        var inputs = {
            min: 0,
            max: 1,
            count: interval,
            decimals: 2,
            continuity: 1
        };

        // fill in color
        var pointBackgroundColors = [];

        document.chkbox.chk0.disabled = true;
        document.chkbox.chk1.disabled = true;
        document.chkbox.chk2.disabled = true;
        document.chkbox.chk3.disabled = true;
        document.chkbox.chk4.disabled = true;
        document.chkbox.chk5.disabled = true;
        document.chkbox.chk6.disabled = true;
        document.chkbox.chk7.disabled = true;
        document.chkbox.chk8.disabled = true;
        document.chkbox.chk9.disabled = true;

        for (i = 0; i < interval; i++) {
            switch(reason[i]){
                case "0":
                    pointBackgroundColors.push("#FF0000");
                    document.chkbox.chk0.disabled = false;
                    break;
                case "1":
                    pointBackgroundColors.push("#FF8800");
                    document.chkbox.chk1.disabled = false;
                    break;
                case "2":
                    pointBackgroundColors.push("#EEEE00");
                    document.chkbox.chk2.disabled = false;
                    break;
                case "3":
                    pointBackgroundColors.push("#00FF00");
                    document.chkbox.chk3.disabled = false;
                    break;
                case "4":
                    pointBackgroundColors.push("#00FFFF");
                    document.chkbox.chk4.disabled = false;
                    break;
                case "5":
                    pointBackgroundColors.push("#0000FF");
                    document.chkbox.chk5.disabled = false;
                    break;
                case "6":
                    pointBackgroundColors.push("#7700FF");
                    document.chkbox.chk6.disabled = false;
                    break;
                case "7":
                    pointBackgroundColors.push("#FF00FF");
                    document.chkbox.chk7.disabled = false;
                    break;
                case "8":
                    pointBackgroundColors.push("#000000");
                    document.chkbox.chk8.disabled = false;
                    break;
                case "9":
                    pointBackgroundColors.push("#888888");
                    document.chkbox.chk9.disabled = false;
                    break;
            }
        }

        var data = {
            labels: time,
            datasets: [{
                //backgroundColor: utils.transparentize(presets.red),
                fill: false,
                //borderColor: presets.red,
                data: brac,
                pointBackgroundColor: pointBackgroundColors,
                hidden: false,
                label: '酒精值Brac'
            }]
        };

        var options = {
            maintainAspectRatio: false,
            spanGaps: false,
            elements: {
                line: {
                    tension: 0.000001
                }
            },
            scales: {
                yAxes: [{
                    stacked: true
                }]
            },
            plugins: {
                filler: {
                    propagate: false
                },
                samples_filler_analyser: {
                    target: 'chart-analyser'
                }
            }
        };

        var chart = new Chart('chart-0', {
            type: 'line',
            data: data,
            options: options
        });

        // checkbox control
        function chk0update(){     
            if(document.chkbox.chk0.checked == false){       
                c0 = 0;
            } else{
                c0 = 1;
            }
            dataupdate();  
        }   
        function chk1update(){     
            if(document.chkbox.chk1.checked == false){ 
                c1 = 0;
            } else{
                //打勾
                c1 = 1;
            }
            dataupdate();
        }  
        function chk2update(){     
            if(document.chkbox.chk2.checked == false){       
                c2 = 0;
            } else{
                c2 = 1;
            }
            dataupdate();  
        }  
        function chk3update(){     
            if(document.chkbox.chk3.checked == false){       
                c3 = 0;
            } else{
                c3 = 1;  
            }
            dataupdate();  
        }  
        function chk4update(){     
            if(document.chkbox.chk4.checked == false){       
                c4 = 0;
            } else{
                c4 = 1;
            }
            dataupdate();    
        }  
        function chk5update(){     
            if(document.chkbox.chk5.checked == false){       
                c5 = 0;
            } else{
                c5 = 1;   
            }
            dataupdate();    
        }  
        function chk6update(){     
            if(document.chkbox.chk6.checked == false){       
                c6 = 0;
            } else{
                c6 = 1;  
            }
            dataupdate(); 
        }  
        function chk7update(){     
            if(document.chkbox.chk7.checked == false){       
                c7 = 0;
            } else{
                c7 = 1;
            }
            dataupdate();  
        } 
        function chk8update(){     
            if(document.chkbox.chk8.checked == false){       
                c8 = 0;
            } else{
                c8 = 1;
            }
            dataupdate();   
        }  
        function chk9update(){     
            if(document.chkbox.chk9.checked == false){       
                c9 = 0;
            } else{
                c9 = 1;
            } 
            dataupdate();   
        } 
        function getMonth(selectObject) {
            month = selectObject.value;  
            dataupdate();
        }
        function getWeek(selectObject) {
            week = selectObject.value; 
            dataupdate();
        }
        function dataupdate(){
            brac = [];
            time = [];
            reason = [];
            pointBackgroundColors = [];
            $.ajax({
                type: 'post',
                url: 'get_brac_data_time.php',
                data: {userid: userid, month: month, week: week, c0: c0, c1: c1, c2: c2, c3: c3, c4: c4, c5: c5, c6: c6, c7: c7, c8: c8, c9: c9},
                dataType: 'json',
                async: false,
                success: function(response) {
                //here I'd like back the php query
                    interval = response.length;
                    for (var i = 0; i < interval; i++){
                        brac.push(response[i].brac);
                        time.push(response[i].time);
                        reason.push(response[i].reason);
                    }
                }
            });
            document.getElementById('interval').innerHTML = interval;
            for (i = 0; i < interval; i++) {
                switch(reason[i]){
                    case "0":
                        pointBackgroundColors.push("#FF0000");
                        break;
                    case "1":
                        pointBackgroundColors.push("#FF8800");
                        break;
                    case "2":
                        pointBackgroundColors.push("#EEEE00");
                        break;
                    case "3":
                        pointBackgroundColors.push("#00FF00");
                        break;
                    case "4":
                        pointBackgroundColors.push("#00FFFF");
                        break;
                    case "5":
                        pointBackgroundColors.push("#0000FF");
                        break;
                    case "6":
                        pointBackgroundColors.push("#7700FF");
                        break;
                    case "7":
                        pointBackgroundColors.push("#FF00FF");
                        break;
                    case "8":
                        pointBackgroundColors.push("#000000");
                        break;
                    case "9":
                        pointBackgroundColors.push("#888888");
                        break;
                }
            }
            updatechart();
            console.log(brac);
            console.log([c0 , c1, c2, c3, c4, c5, c6, c7, c8, c9]);
        }
        function showall_brac(){
            console.log("showall");
            brac = [];
            time = [];
            reason = [];
            pointBackgroundColors = [];
            $.ajax({
                type: 'post',
                url: 'get_brac_data.php',
                data: "userid="+ userid,
                dataType: 'json',
                async: false,
                success: function(response) {
                //here I'd like back the php query
                    interval = response.length;
                    for (var i = 0; i < interval; i++){
                        brac.push(response[i].brac);
                        time.push(response[i].time);
                        reason.push(response[i].reason);
                    }
                }
            });
            document.getElementById('interval').innerHTML = interval;
            for (i = 0; i < interval; i++) {
                switch(reason[i]){
                    case "0":
                        pointBackgroundColors.push("#FF0000");
                        break;
                    case "1":
                        pointBackgroundColors.push("#FF8800");
                        break;
                    case "2":
                        pointBackgroundColors.push("#EEEE00");
                        break;
                    case "3":
                        pointBackgroundColors.push("#00FF00");
                        break;
                    case "4":
                        pointBackgroundColors.push("#00FFFF");
                        break;
                    case "5":
                        pointBackgroundColors.push("#0000FF");
                        break;
                    case "6":
                        pointBackgroundColors.push("#7700FF");
                        break;
                    case "7":
                        pointBackgroundColors.push("#FF00FF");
                        break;
                    case "8":
                        pointBackgroundColors.push("#000000");
                        break;
                    case "9":
                        pointBackgroundColors.push("#888888");
                        break;
                }
            }
            console.log(brac);
            updatechart();
        }
        function updatechart(){
            chart.destroy();
            data = {
                labels: time,
                datasets: [{
                    //backgroundColor: utils.transparentize(presets.red),
                    fill: false,
                    //borderColor: presets.red,
                    data: brac,
                    pointBackgroundColor: pointBackgroundColors,
                    hidden: false,
                    label: '酒精值Brac'
                }]
            };
            options = {
                maintainAspectRatio: false,
                spanGaps: false,
                elements: {
                    line: {
                        tension: 0.000001
                    }
                },
                scales: {
                    yAxes: [{
                        stacked: true
                    }]
                },
                plugins: {
                    filler: {
                        propagate: false
                    },
                    samples_filler_analyser: {
                        target: 'chart-analyser'
                    }
                }
            };
            chart = new Chart('chart-0', {
                type: 'line',
                data: data,
                options: options
            });
        }
        /*
        function removeORadd(item, type){
            if(type == 1){
                for (var i = brac_show.length; i>0; i--){
                    if(reason[i] == item){
                        brac_show.splice(i, 1);
                        reason.splice(i, 1);
                        brac_control[i] = -1;
                    }
                }
            } else{
                for (var i = brac_backup.length; i>0; i--){
                    if(reason_backup[i] == item){
                        brac_show.splice(i, 1);
                        reason.splice(i, 1);
                        brac_control[i] = -1;
                    }
                }
            }
        }
        */
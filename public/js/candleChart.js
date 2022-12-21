    // var url_string = window.location.href;
    // var url = new URL(url_string);
    // var asset = url.searchParams.get("asset");
    // var periode = url.searchParams.get("periode");
    // var reload = url.searchParams.get("reload");
    var asset = document.getElementById('pair').value;
    var periode = "30m";
    var reload = 15;
    if (asset === null || asset === undefined) {
        asset = "BTCUSDT";
    }
    if (periode === null || periode === undefined) {
        periode = "30m";
    }
    if (reload === null || reload === undefined) {
        reload = 15;
    }
    var counter = reload;
    var color = "#ff0000";
    var periodeMA = 50;
    var perMAE = 5;
    var perSH = 14;
    getData(false);

    function processData(Lists, isCross) {
        var cross = [];
        var res = [];
        var list;
        var sh=0;
        var start = 0;
        periodeSH = perSH;
        if(periodeMA<periodeSH){
            list = Lists.slice(periodeSH, (Lists.length));
            start = periodeSH-periodeMA;
        }else{
            list = Lists.slice(periodeMA, (Lists.length));
            sh = (periodeMA-periodeSH);
            periodeSH = periodeMA;
        }
        periodeMAE = perMAE + 1;
        var persenK = [];
        var tgl = '';
        var mae = 0;

        //PSAR
        var Acc = 0.02;
        var EP = parseFloat(list[0][3]);
        var hp = parseFloat(list[0][2]);
        var lp = parseFloat(list[0][3]);
        var up = true;
        var PSar;

        for (var i = 0; i < list.length; i++) {
            //Simpan data candle: Close, Open, High dan Low kedalam variabel dp
            var dp = {};
            var arrow = {};
            dp["open"] = list[i][1];
            dp["high"] = list[i][2];
            dp["low"] = list[i][3];
            dp["close"] = list[i][4];
            tgl = new Date(list[i][0]);
            dp["date"] = tgl;

            //Hitung Moving Average dari data indeks ke-0, dan simpan ke variabel dp pada indeks
            var sum = 0;
            for (var j = (i+start); j < (i + periodeMA + start); j++) {
                sum = sum + parseFloat(Lists[j][4]);
            }
            sum = sum / periodeMA;
            dp["ma"] = sum.toFixed(8);

            //Hitung Moving Average Eksponensial dan simpan ke variabel dp pada indeks mae
            var close = parseFloat(list[i][4]);
            if (i == 0) {
                mae = ((close - sum) * (2 / periodeMAE)) + sum;
            } else {
                mae = ((close - mae) * (2 / periodeMAE)) + mae;
            }
            dp["mae"] = mae.toFixed(8);

            //Hitung Cross
            if (i > 1) {
                if (res[i - 1].ma < res[i - 1].mae) {
                    if (res[i - 2].ma > res[i - 2].mae) {
                        tgl = new Date(list[i - 2][0]);
                        arrow["date"] = tgl;
                        arrow["type"] = "arrowUp";
                        arrow["fontSize "] = 250;
                        arrow["backgroundColor"] = "#00CC00";
                        arrow["graph"] = "MAE";
                        arrow["description"] = "Harga mau naik, Ayo Beli !!!";
                        cross.push(arrow);
                    }
                } else if (res[i - 1].ma > res[i - 1].mae) {
                    if (res[i - 2].ma < res[i - 2].mae) {
                        tgl = new Date(list[i - 2][0]);
                        arrow["date"] = tgl;
                        arrow["type"] = "arrowDown";
                        arrow["fontSize "] = 250;
                        arrow["backgroundColor"] = "#e411e8";
                        arrow["graph"] = "MAE";
                        arrow["description"] = "Harga mau turun, Ayo Jual !!!";
                        cross.push(arrow);
                    }
                }
            }

            // Hitung Stochastic
            var close = 0;
            var max = 0,
                min = 0;

            for (var j = (i+sh); j <= (i + periodeMA); j++) {
                if(typeof Lists[j] == 'undefined'){
                    console.log(j);
                }
                var high = parseFloat(Lists[j][2]);
                var low = parseFloat(Lists[j][3]);
                if (max <= high) {
                    max = high;
                }
                if (min >= low || min == 0) {
                    min = low;
                }
            }
            close = parseFloat(list[i][4]);
            persenK[i] = (100 * (close - min)) / (max - min);
            dp["%K"] = (persenK[i]).toFixed(2);
            if (i >= 2) {
                sum = 0;
                for (var j = i - 2; j <= i; j++) {
                    sum = sum + persenK[j];
                }
                dp["%D"] = sum/3;
                // dp["%K"] = (persenK[i]).toFixed(2);
                // if(i >= 5){
                //     sum=0;
                //     for (var j = i - 2; j <= i; j++) {
                //         sum = sum + persenK[j];
                //     }
                //     dp["%D"] = (sum / 3).toFixed(2);
                // }else{
                //     dp["%D"] = (persenK[i]).toFixed(2);
                // }
            } else {
                dp["%D"] = 0;
            }

            // var sumGain = 0;
            // var sumLoss = 0;
            // var rsi = [];
            // var min = 102;
            // var max = 0;
            // var sumRSI = 0;
            // var avgRSI = 0;
            // // console.log(i);
            // for(var k = 0; k < 14; k++){
            //     sumGain = 0;
            //     sumLoss = 0;
            //     for (var j = (i+sh-12+k); j <= (i + periodeSH-13+k); j++) {
            //         if(typeof Lists[j] == 'undefined'){
            //             console.log(j);
            //         }
            //         var ch = parseFloat(Lists[j][4]) - parseFloat(Lists[j-1][4]);
            //         if (ch >= 0){
            //             sumGain += ch;
            //         }else{
            //             sumLoss -= ch;
            //             // console.log(j+" > "+ch+" - "+sumLoss);
            //         }
            //     }
            //     var avgGain = sumGain / (periodeSH-sh);
            //     var avgLoss = sumLoss / (periodeSH-sh);
            //     // var smooth = 1/3;
            //     // var avgG1 = (smooth * sumGain) + ((1-smooth)*avgGain);
            //     // var avgL1 = (smooth * sumLoss) + ((1-smooth)*avgLoss);
            //     // var avgG2 = (avgGain * 13) + sumGain;
            //     // var avgL2 = (avgLoss * 13) + sumLoss;
            //     // avgGain = (avgG1 + avgG2 + avgGain)/3;
            //     // avgLoss = (avgL1 + avgL2 + avgLoss)/3;
            //     var rs = avgGain / avgLoss;
            //     if(isNaN(rs)){
            //         rs=0;
            //     }
            //     rsi[k] = 100.0 - (100.0 / (1 + rs));
            //     if(max <= rsi[k]){
            //         max = rsi[k];
            //     }
            //     if(min >= rsi[k]){
            //         min = rsi[k];
            //     }
            // }
            // persenK[i] = 100*(rsi[rsi.length-1] - min)/ Math.max((max-min), 1);
            // // perK = 100*(persenK[i]);
            // dp["%K"] = (persenK[i]).toFixed(2);
            // if (i >= 2) {
            //     sum = 0;
            //     for (var j = i - 2; j <= i; j++) {
            //         sum = sum + persenK[j];
            //     }
            //     // dp["%D"] = (sum / 3).toFixed(2);
            //     persenK[i] = (sum/3);
            //     // persenK[i] = persenK[i] || perK;
            //     dp["%K"] = (persenK[i]).toFixed(2);
            //     if(i >= 5){
            //         sum=0;
            //         for (var j = i - 2; j <= i; j++) {
            //             sum = sum + persenK[j];
            //         }
            //         dp["%D"] = (sum / 3).toFixed(2);
            //     }else{
            //         dp["%D"] = (persenK[i]).toFixed(2);
            //     }
            // } else {
            //     dp["%D"] = (persenK[i]).toFixed(2);
            // }

            //Hitung Parabolic SAR
            if (i > 0) {
                SARn = PSar;
                if (up) {
                    PSar = SARn + Acc * (hp - SARn);
                } else {
                    PSar = SARn + Acc * (lp - SARn);
                }
                var reverse = false;
                if (up) {
                    if (list[i][3] < PSar) {
                        up = false;
                        reverse = true;
                        PSar = hp;
                        lp = parseFloat(list[i][3]);
                        Acc = 0.02;
                    }
                } else {
                    if (list[i][2] > PSar) {
                        up = true;
                        reverse = true;
                        PSar = lp;
                        hp = parseFloat(list[i][2]);
                        Acc = 0.02
                    }
                }
                if (!reverse && i > 1) {
                    if (up) {
                        if (list[i][2] > hp) {
                            hp = parseFloat(list[i][2]);
                            Acc = Math.min(Acc + 0.02, 0.2);
                        }
                        if (list[i - 1][3] < PSar) {
                            PSar = parseFloat(list[i - 1][3]);
                        }
                        if (list[i - 2][3] < PSar) {
                            PSar = parseFloat(list[i - 2][3]);
                        }
                    } else {
                        if (list[i][3] < lp) {
                            lp = list[i][3];
                            Acc = Math.min(Acc + 0.02, 0.2);
                        }
                        if (list[i - 1][2] > PSar) {
                            PSar = parseFloat(list[i - 1][2]);
                        }
                        if (list[i - 2][2] > PSar) {
                            PSar = parseFloat(list[i - 2][2]);
                        }
                    }
                }
            } else {
                PSar = list[i][4];
            }
            PSar = parseFloat(PSar);
            dp["PSar"] = PSar.toFixed(8);

            //Masukkan variabel dp kedalam array res.
            res.push(dp);
        }
        // console.log(res);
        if (isCross) {
            return cross;
        } else {
            return res;
        }
    }

    function getData(isUpdate) {
        $.when(
            $.ajax({
                url: "../../api/binance/kline/"+asset,
                type: "GET",
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                dataType: 'json',
            })
        ).then(function (chartData) {
            var length = chartData.length;
            dataSet = chartData;
            if(chartData.length >= 500){
                dataSet = chartData.slice(length - 250, length);
            }
            // console.log(dataSet);
            chartData = processData(dataSet, false);
            var getCross = processData(dataSet, true);

            if (isUpdate) {
                chart.dataSets[0].dataProvider = chartData;
                chart.dataSets[0].stockEvents = getCross;
                chart.validateData();
            } else {
                render(chartData, getCross);
            }
        });
    }

    function render(chartData, getCross) {
        chart = AmCharts.makeChart("chartdiv", {
            "type": "stock",
            "theme": "light",
            "categoryAxesSettings": {
                "minPeriod": "mm",
                "groupToPeriods": ['hh', 'hh']
            },
            "responsive": {
                "enabled": true
            },
            "valueAxesSettings": {
                "inside": false,
                "offset": -5
            },
            "chartCursorSettings": {
                "fullWidth": false,
                "pan": true,
                "valueBalloonsEnabled": true,
                "valueLineEnabled": true,
                "valueLineBalloonEnabled": true,
                "valueLineAlpha": 1
            },
            "dataSets": [{
                "fieldMappings": [{
                    "fromField": "open",
                    "toField": "open"
                }, {
                    "fromField": "close",
                    "toField": "close"
                }, {
                    "fromField": "high",
                    "toField": "high"
                }, {
                    "fromField": "low",
                    "toField": "low"
                }, {
                    "fromField": "PSar",
                    "toField": "PSar"
                }, {
                    "fromField": "%K",
                    "toField": "%K"
                }, {
                    "fromField": "%D",
                    "toField": "%D"
                }, {
                    "fromField": "rsi",
                    "toField": "rsi"
                }, {
                    "fromField": "ma",
                    "toField": "ma"
                }, {
                    "fromField": "mae",
                    "toField": "mae"
                }, {
                    "fromField": "date",
                    "toField": "date"
                }],
                "color": "#7f8da9",
                "dataProvider": chartData,
                "categoryField": "date",
                "stockEvents": getCross,
            }],
            "panels": [{
                "percentHeight": 100,
                "showCategoryAxis": false,
                "stockGraphs": [{
                    "id": "g1",
                    "title": "Close",
                    "type": "candlestick",
                    "openField": "open",
                    "closeField": "close",
                    "highField": "high",
                    "lowField": "low",
                    "valueField": "close",
                    "lineColor": "#7f8da9",
                    "fillColors": "#7f8da9",
                    "negativeLineColor": "#db4c3c",
                    "negativeFillColors": "#db4c3c",
                    "fillAlphas": 1,
                    "balloonText": "Open:<b>[[open]]</b><br>Close:<b>[[close]]</b><br>Low:<b>[[low]]</b><br>High:<b>[[high]]</b>",
                    "valueAxis": "Caxis1"
                }, {
                    "lineAlpha": 0,
                    "showBalloon": false,
                    "visibleInLegend": false,
                    "valueAxis": "Caxis2",
                    "valueField": "close"
                }, {
                    "id": "MA",
                    "title": "MA "+periodeMA+" - (Moving Average)",
                    "balloonText": "MA : [[value]]",
                    "lineAlpha": 1,
                    "lineThickness": 2,
                    "lineColor": "#f00",
                    "type": "line",
                    "valueField": "ma",
                    "useDataSetColors": false
                }, {
                    "id": "MAE",
                    "title": "MAE "+perMAE+" - (Moving Average Eksponensial)",
                    "balloonText": "MAE : [[value]]",
                    "lineAlpha": 1,
                    "lineThickness": 2,
                    "lineColor": "#00f",
                    "type": "line",
                    "valueField": "mae",
                    "useDataSetColors": false
                }, {
                    "id": "PSAR",
                    "title": "Parabolic SAR",
                    "balloonText": "PSAR : [[value]]",
                    "lineAlpha": 0,
                    "lineThickness": 1,
                    "bulletColor": "#1299e8",
                    "type": "line",
                    "valueField": "PSar",
                    "bullet": "round",
                    "bulletSize": 5,
                    "useDataSetColors": false
                }],
                "stockLegend": {
                    "position": "bottom",
                    "maxColumns": 5,
                    "spacing": 50,
                    "useGraphSettings": true,
                    "divId": "legends"
                },
                "valueAxes": [{
                    "id": "Caxis1",
                    "autoGridCount": false,
                    "position": "left",
                }, {
                    "id": "Caxis2",
                    "position": "right",
                }]
            }, {
                "title": "Stochastic",
                "percentHeight": 50,
                "marginsLeft": 30,
                "marginsRight": 30,
                "guides": [{
                    "fillAlpha": 0.3,
                    "fillColor": "#bfbfbf",
                    "lineAlpha": 0,
                    "toValue": 80,
                    "value": 20
                }],
                "valueAxes": [{
                    "id": "axis1",
                    "minimum": 0,
                    "maximum": 110,
                    "minVerticalGap": 10,
                    "position": "left"
                }, {
                    "id": "axis2",
                    "minimum": 0,
                    "maximum": 110,
                    "minVerticalGap": 10,
                    "position": "right",
                    "autoWrap": true
                }],
                "stockGraphs": [{
                    "id": "%K",
                    "title": "%K",
                    "type": "line",
                    "balloonText": "%K : [[value]]",
                    "lineAlpha": 1,
                    "lineThickness": 1,
                    "lineColor": "#37ff30",
                    "valueField": "%K",
                    "valueAxis": "axis1",
                    "useDataSetColors": false
                }, {
                    "id": "%D",
                    "title": "%D",
                    "type": "line",
                    "balloonText": "%D : [[value]]",
                    "lineAlpha": 1,
                    "lineThickness": 1,
                    "lineColor": "#f00",
                    "valueField": "%D",
                    "valueAxis": "axis1",
                    "useDataSetColors": false
                }, {
                    "lineAlpha": 0,
                    "showBalloon": false,
                    "visibleInLegend": false,
                    "valueAxis": "axis2",
                    "valueField": "close"
                }],
                "stockLegend": {
                    "position": "bottom",
                    "maxColumns": 3,
                    "spacing": 50,
                    "useGraphSettings": true
                }
            }],
            "panelsSettings": {
                "marginLeft": 50,
                "marginRight": 50,
                "startEffect": "easeOutSine",
                "startAplha": 0,
                "startDuration": 0.5,
            },
            "chartScrollbarSettings": {
                "graph": "g1",
                "graphType": "line",
                "usePeriod": "mm",
                "updateOnReleaseOnly": false,
                "height": 30
            },
            "periodSelector": {
                "position": "bottom",
                "inputFieldsEnabled": false,
                "dateFormat": "JJ:NN",
                "inputFieldWidth": 150,
                "periods": [{
                    "period": "DD",
                    "count": 1,
                    "label": "1 Day"
                }, {
                    "period": "DD",
                    "count": 3,
                    "label": "3 Day",
                    "selected": true
                }, {
                    "period": "MAX",
                    "label": "MAX"
                }]
            },
            "export": {
                "enabled": true,
                "position": "top-right"
            },
        });

        setInterval(function () {
            console.log(counter);
            if (counter == 0) {
                getData(true);
                counter = reload;
            } else {
                counter--;
            }
        }, 1000);
        
        // chart.addListener( "drawn", function( e ) {
        //     // WAIT FOR FABRIC
        //     var interval = setInterval( function() {
        //         // if ( window.fabric ) {
        //             clearTimeout( interval );

        //             // CAPTURE CHART
        //             e.chart["export"].capture({}, function () {
        //                 this.toPNG({}, function (base64) {
        //                     $.ajax({
        //                         url: "mabinance.php",
        //                         type: "POST",
        //                         data: {
        //                             imgdata: base64
        //                         }
        //                     });
        //                 });
        //             });
        //         // }
        //     }, 10 );
        // });
    }

<script>
    const counterUp = window.counterUp.default

    $(function() {

        let el = document.querySelectorAll( '.counter' );

        // Start counting, typically you need to call this when the
        // element becomes visible, or whenever you like.
        for (var i = 0; i < el.length; i++) {
            counterUp( el[i], {
                duration: 1000,
                delay: 16,
            } )
        }

        new chartLawYearlyColumn('chart_yearly_column');

        $('.select-search').select2({
            dropdownParent: $('#filter-dropdown-container')
        });

        $('.select').select2({
            minimumResultsForSearch: Infinity
        });

        $(".filter-form").submit(function() {
            $(this).find(":input").filter(function(){ return !this.value; }).attr("disabled", "disabled");
            return true;
        });

        const bannerSlider = tns({
            "container": "#banner-slider",
            "loop": true,
            "responsive": {
                "350": {
                "items": 1
                },
                "500": {
                "items": 4
                }
            },
            "gutter": 20,
            "controls": false,
            "mouseDrag": true,
            "nav": true,
            "navPosition": "bottom",
        });

        const memberSlider = tns({
            "container": "#member-slider",
            "loop": true,
            "responsive": {
                "350": {
                "items": 2
                },
                "500": {
                "items": 4
                }
            },
            "gutter": 20,
            "controls": false,
            "mouseDrag": true,
            "slideBy": 1,
            "nav": true,
            "navPosition": "bottom",
        });

        const newsSlider = tns({
            "container": "#news-slider",
            "loop": true,
            "items": 3,
            "gutter": 20,
            "controls": false,
            "mouseDrag": true,
            "slideBy": 1,
            "nav": true,
            "navPosition": "bottom",
        });
    })

    function chartLawYearlyColumn(elementId) {

        $.ajaxSetup({
            headers: {
                'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: '/legislation/law-yearly-column-chart',
            type: 'POST',
            dataType: 'JSON',
        }).done(function(response) {

            // Define element
            var columns_basic_element = document.getElementById(elementId);

            //
            // Charts configuration
            //

            if (columns_basic_element) {

                // Initialize chart
                var columns_basic = echarts.init(columns_basic_element, null, { renderer: 'svg' });


                //
                // Chart config
                //

                // Options
                columns_basic.setOption({

                    // Define colors
                    color: ['#5c6bc0', '#2ec7c9','#b6a2de','#5ab1ef','#ffb980','#d87a80'],

                    // Global text styles
                    textStyle: {
                        fontFamily: 'var(--body-font-family)',
                        color: 'var(--body-color)',
                        fontSize: 14,
                        lineHeight: 22,
                        textBorderColor: 'transparent'
                    },

                    // Chart animation duration
                    animationDuration: 750,

                    // Setup grid
                    grid: {
                        left: 0,
                        right: 45,
                        top: 35,
                        bottom: 0,
                        containLabel: true
                    },

                    // Add legend
                    legend: {
                        data: response.categories,
                        itemHeight: 8,
                        itemGap: 30,
                        textStyle: {
                            color: 'var(--body-color)',
                            padding: [0, 5]
                        }
                    },

                    // Add tooltip
                    tooltip: {
                        trigger: 'axis',
                        className: 'shadow-sm rounded',
                        backgroundColor: 'var(--white)',
                        borderColor: 'var(--gray-400)',
                        padding: 15,
                        textStyle: {
                            color: '#000'
                        },
                        axisPointer: {
                            type: 'shadow',
                            shadowStyle: {
                                color: 'rgba(var(--body-color-rgb), 0.025)'
                            }
                        }
                    },

                    // Horizontal axis
                    xAxis: [{
                        type: 'category',
                        data: response.years,
                        axisLabel: {
                            color: 'rgba(var(--body-color-rgb), .65)'
                        },
                        axisLine: {
                            lineStyle: {
                                color: 'var(--gray-500)'
                            }
                        },
                        splitLine: {
                            show: true,
                            lineStyle: {
                                color: 'var(--gray-300)',
                                type: 'dashed'
                            }
                        }
                    }],

                    // Vertical axis
                    yAxis: [{
                        type: 'value',
                        axisLabel: {
                            color: 'rgba(var(--body-color-rgb), .65)'
                        },
                        axisLine: {
                            show: true,
                            lineStyle: {
                                color: 'var(--gray-500)'
                            }
                        },
                        splitLine: {
                            lineStyle: {
                                color: 'var(--gray-300)'
                            }
                        },
                        splitArea: {
                            show: true,
                            areaStyle: {
                                color: ['rgba(var(--white-rgb), .01)', 'rgba(var(--black-rgb), .01)']
                            }
                        }
                    }],

                    // Add series
                    series: response.series
                });
            }

            //
            // Resize charts
            //

            // Resize function
            var triggerChartResize = function() {
                columns_basic_element && columns_basic.resize();
            };

            // On sidebar width change
            var sidebarToggle = document.querySelectorAll('.sidebar-control');
            if (sidebarToggle) {
                sidebarToggle.forEach(function(togglers) {
                    togglers.addEventListener('click', triggerChartResize);
                });
            }

            // On window resize
            var resizeCharts;
            window.addEventListener('resize', function() {
                clearTimeout(resizeCharts);
                resizeCharts = setTimeout(function () {
                    triggerChartResize();
                }, 200);
            });
        });

        }
</script>

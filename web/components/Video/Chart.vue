<template>
    <div>
        <vue-highcharts :options="options" classname="video-chart" ref="lineCharts"></vue-highcharts>
    </div>
</template>

<script>
    import VueHighcharts from 'vue2-highcharts'

    export default {
        components: {
            VueHighcharts
        },
        props: {
            id: {
                required: true
            }
        },
        data() {
            return {
                options: {
                    chart: {
                        type: 'spline'
                    },
                    title: {
                        text: "Статистика"
                    },
                    xAxis: {
                        title: {
                            text: "Время"
                        },
                        dateTimeLabelFormats: {
                            millisecond: '%H:%M:%S',
                        },
                        type: 'datetime'
                    },
                    yAxis: {
                        title: {
                            text: "Кол-во"
                        }
                    },
                    series: []
                }
            }
        },
        mounted() {
            this.load();
        },
        methods: {
            async load() {
                let lineCharts = this.$refs.lineCharts;
                lineCharts.delegateMethod('showLoading', 'Loading...');

                try {
                    await this.$videoRepository.metrics(this.id).forEach((series) => {
                        lineCharts.addSeries(series);
                    });
                    response.data
                } catch (e) {}

                lineCharts.hideLoading();
            }
        }
    }
</script>
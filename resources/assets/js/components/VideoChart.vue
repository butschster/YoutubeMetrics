<template>
    <div>
        <vue-highcharts :options="options" classname="" ref="lineCharts"></vue-highcharts>
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
            load() {
                let lineCharts = this.$refs.lineCharts;
                lineCharts.delegateMethod('showLoading', 'Loading...');

                axios.get(`/api/video/${this.id}/metrics`)
                    .then(r => {
                        r.data.forEach((series) => {
                            lineCharts.addSeries(series);
                        });

                        lineCharts.hideLoading();
                    })
                    .catch((e) => {
                        lineCharts.hideLoading();
                    });
            }
        }
    }
</script>
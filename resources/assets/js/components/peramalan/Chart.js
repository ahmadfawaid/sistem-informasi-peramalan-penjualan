import { Line } from 'vue-chartjs'
export default {
    extends: Line,
    props: {
        chartActual: {
            type: Array | Object,
            required: false
        },
        chartForecast: {
            type: Array | Object,
            required: false
        },
        chartLabels: {
            type: Array,
            required: true
        }
    },
    data () {
        return {
            options: {
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero: true
                        },
                        gridLines: {
                            display: true
                        }
                    }],
                    xAxes: [{
                        gridLines: {
                            display: false
                        }
                    }]
                },
                bodyFontFamily: 'Circular Family',
                footerFontFamily: 'Circular Family',
                legend: {
                    display: false
                },
                responsive: true,
                maintainAspectRatio: false
            }
        }
    },
    mounted () {
        this.renderChart({
            labels: this.chartLabels,
            datasets: [
                {
                    label: 'peramalan',
                    borderColor: '#13ce66',
                    pointBackgroundColor: 'white',
                    borderWidth: 2,
                    pointBorderColor: '#13ce66',
                    backgroundColor: 'transparent',
                    data: this.chartForecast
                },
                {
                    label: 'aktual',
                    borderColor: '#0065ff',
                    pointBackgroundColor: 'white',
                    borderWidth: 2,
                    pointBorderColor: '#0065ff',
                    backgroundColor: 'transparent',
                    data: this.chartActual
                }
            ]
        }, this.options)
    }
}
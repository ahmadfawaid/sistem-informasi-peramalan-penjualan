import { Line } from 'vue-chartjs'
export default {
    extends: Line,
    props: {
        chartData: {
            type: Array | Object,
            required: true
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
                    label: 'penjualan',
                    borderColor: '#0065ff',
                    pointBackgroundColor: 'white',
                    borderWidth: 2,
                    pointBorderColor: '#0065ff',
                    backgroundColor: 'transparent',
                    data: this.chartData
                }
            ]
        }, this.options)
    }
}
document.addEventListener('DOMContentLoaded', function() {
    const chartElement = document.getElementById('chart');
    const chartType = chartElement.dataset.type;
    
    ReactDOM.render(
        React.createElement(ChartComponent, { type: chartType, data: adv_dv_data.csv_data }),
        chartElement
    );
});

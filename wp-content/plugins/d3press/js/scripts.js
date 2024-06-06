document.addEventListener('DOMContentLoaded', function() {
    const csvData = adv_dv_data.csv_data;
    const chartType = document.getElementById('chart').dataset.type;
    
    if (!csvData) {
        console.error('No CSV data found');
        return;
    }

    const data = csvData.slice(1).map(row => {
        return {
            label: row[0],
            value: +row[1]
        };
    });

    const svg = d3.select("#chart").append("svg")
        .attr("width", "100%")
        .attr("height", "100%");

    if (chartType === 'bar') {
        const margin = {top: 20, right: 30, bottom: 40, left: 40};
        const width = svg.node().getBoundingClientRect().width - margin.left - margin.right;
        const height = svg.node().getBoundingClientRect().height - margin.top - margin.bottom;

        const x = d3.scaleBand()
            .domain(data.map(d => d.label))
            .range([margin.left, width - margin.right])
            .padding(0.1);

        const y = d3.scaleLinear()
            .domain([0, d3.max(data, d => d.value)]).nice()
            .range([height - margin.bottom, margin.top]);

        const xAxis = g => g
            .attr("transform", `translate(0,${height - margin.bottom})`)
            .call(d3.axisBottom(x).tickSizeOuter(0));

        const yAxis = g => g
            .attr("transform", `translate(${margin.left},0)`)
            .call(d3.axisLeft(y));

        svg.append("g")
            .selectAll("rect")
            .data(data)
            .join("rect")
            .attr("x", d => x(d.label))
            .attr("y", d => y(d.value))
            .attr("height", d => y(0) - y(d.value))
            .attr("width", x.bandwidth())
            .attr("fill", "steelblue");

        svg.append("g").call(xAxis);
        svg.append("g").call(yAxis);

    } else if (chartType === 'line') {
        const margin = {top: 20, right: 30, bottom: 40, left: 40};
        const width = svg.node().getBoundingClientRect().width - margin.left - margin.right;
        const height = svg.node().getBoundingClientRect().height - margin.top - margin.bottom;

        const x = d3.scalePoint()
            .domain(data.map(d => d.label))
            .range([margin.left, width - margin.right]);

        const y = d3.scaleLinear()
            .domain([0, d3.max(data, d => d.value)]).nice()
            .range([height - margin.bottom, margin.top]);

        const xAxis = g => g
            .attr("transform", `translate(0,${height - margin.bottom})`)
            .call(d3.axisBottom(x).tickSizeOuter(0));

        const yAxis = g => g
            .attr("transform", `translate(${margin.left},0)`)
            .call(d3.axisLeft(y));

        const line = d3.line()
            .x(d => x(d.label))
            .y(d => y(d.value));

        svg.append("g")
            .append("path")
            .datum(data)
            .attr("fill", "none")
            .attr("stroke", "steelblue")
            .attr("stroke-width", 1.5)
            .attr("d", line);

        svg.append("g").call(xAxis);
        svg.append("g").call(yAxis);

    } else if (chartType === 'pie') {
        const radius = Math.min(svg.node().getBoundingClientRect().width, svg.node().getBoundingClientRect().height) / 2;
        const g = svg.append("g").attr("transform", `translate(${radius},${radius})`);

        const pie = d3.pie().value(d => d.value)(data);

        const arc = d3.arc()
            .innerRadius(0)
            .outerRadius(radius);

        const color = d3.scaleOrdinal(d3.schemeCategory10);

        g.selectAll("path")
            .data(pie)
            .enter().append("path")
            .attr("d", arc)
            .attr("fill", d => color(d.data.label));
    }
});

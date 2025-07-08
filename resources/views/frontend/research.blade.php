@extends('frontend.layouts.header')
@section('title', "Checkout")
@section('description', "")
@section('keywords', "")

@section('content')
<div class="container py-5">
    <!-- Quality Assurance Process -->
    <h2 class="mb-3 text-primary">Quality Assurance Process</h2>
    <p>We Market Research Quality Assurance program strives to deliver superior value to our clients.</p>
    <p>We Market Research senior associate is assigned to each consulting engagement and works closely with the project team to deliver as per the client’s expectations.</p>

    <h4>Market Research Process</h4>
    <img src="{{ asset('assets') }}/images/download.png" alt="Market Research Process" class="img-fluid mb-4">

    <p>We Market Research monitors 3 important attributes during the QA process: Cost, Schedule & Quality. We follow them as critical benchmarks in assessing a project’s success.</p>

    <p><strong>To mitigate risks that can impact project success, we deploy the below project delivery best practices:</strong></p>
    <ul>
        <li>Focused Market Research documentation</li>
        <li>Project health checks with QA Checklists</li>
        <li>Multiple validation & QA of data collection and project deliverables</li>
        <li>Clearly defined SOW, methodologies, & outcomes</li>
        <li>Methodology fitment check</li>
        <li>Market validation value post-project</li>
    </ul>

    <!-- Case Study - Automotive Sector -->
    <div class="bg-light p-4 my-5 rounded">
        <h3>Case Study - Automotive Sector</h3>
        <p>One of the key manufacturers of automobiles had plans to invest in electric utility vehicles. The product line was assessed based on feasibility of growth by sectors, both demand (fleet operators) and supply (local dealerships, strategic tie-ups) side. We Market Research was hired to analyze the market size, demand evolution, and regional potential.</p>

        <h5>Solution</h5>
        <p>The product study was conducted in three stages, including helping the client invest in EV strategy. Research was split as per the region, application, and decision-makers. A combination of secondary research was done to get the workforce patterns, vehicle models, etc. The final stage of analysis included interviews with all stakeholders, dealers, and regional teams. This helped the client understand penetration rate, pricing ranges, and most preferred electric utility types in urban and rural use cases.</p>

        <p>The outcome helped include primary research in focused decision-making. Based on the research stage and regional analysis, a focused Market Research plan was built and a clear go-to-market (GTM) strategy was designed.</p>

        <h5>Market Estimation and Forecast</h5>
        <p>In the final stage of analysis, market forecast for the electric utility sales (based on multiple market approaches) was prepared. This has helped the client get a complete overview of the national and regional strategic potential.</p>
    </div>

    <!-- Case Study - ICT Sector -->
    <div class="bg-light p-4 my-5 rounded">
        <h3>Case Study - ICT Sector</h3>
        <p>Business solution included estimating the office telecom software size from both supply and demand side. As per secondary sources, the ICT Software Market in Tier 1 cities had significant movement (post-pandemic) and Tier 2 cities were also growing in adoption. Our project management methodology tracked over 30 countries. Additionally, the client also sought product positioning in the market and the revenue breakdown in terms of regions and application.</p>

        <h5>Business Solution</h5>
        <p>A robust assessment study was conducted based on primary and secondary research that involved tracking vendors, end-users, competitors, and B2B interactions. As per findings, the consulting model enabled the client to establish a firm idea of the ideal ICP. A competitive matrix was created which also helped in value capture based on the client goal. A segmentation analysis was also done to track which customer segments were the most responsive to their marketing strategies. Based on insights, product customization and feature-based demands were recommended that met the future forecasts.</p>

        <h5>Conclusion</h5>
        <p>The report aided the client in understanding the market trends, including country-level business forecasts, financial modeling, market penetration strategies, and revenue modeling. Strategic planning of crucial phases and detailed scenario estimation and forecasts in 2021.</p>
    </div>
</div>

@endsection
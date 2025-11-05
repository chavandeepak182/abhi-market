<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Roadmap Infographic</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
  <style>
    body {
      background: #fff;
      font-family: 'Poppins', sans-serif;
    }

    .roadmap {
      position: relative;
      margin: 100px auto;
      width: 90%;
      max-width: 1200px;
    }

    .roadmap-title {
      text-align: center;
      margin-bottom: 70px;
    }

    .roadmap-title h2 {
      font-weight: 700;
      letter-spacing: 2px;
    }

    .timeline {
      position: relative;
      display: flex;
      justify-content: space-between;
      flex-wrap: wrap;
    }

    .timeline::before {
      content: "";
      position: absolute;
      top: 50%;
      left: 0;
      width: 100%;
      height: 3px;
      background: #eee;
      z-index: 1;
    }

    .circle {
      position: relative;
      width: 110px;
      height: 110px;
      border-radius: 50%;
      background: #fff;
      border: 6px solid;
      z-index: 2;
      display: flex;
      justify-content: center;
      align-items: center;
      margin-bottom: 120px;
      box-shadow: 0 5px 10px rgba(0,0,0,0.1);
    }

    .circle i {
      font-size: 28px;
      margin-bottom: 8px;
    }

    .timeline-item {
      position: relative;
      text-align: center;
      width: 12%;
    }

    .timeline-item:nth-child(even) .circle {
      margin-top: 120px;
      margin-bottom: 0;
    }

    .timeline-item h4 {
      font-weight: 700;
      font-size: 18px;
      margin-top: 10px;
    }

    .timeline-item p {
      font-size: 14px;
      color: #666;
    }

    /* Circle Colors */
    .circle-1 { border-color: #3e4eb8; color: #3e4eb8; }
    .circle-2 { border-color: #f4b000; color: #f4b000; }
    .circle-3 { border-color: #f66d6d; color: #f66d6d; }
    .circle-4 { border-color: #00b39f; color: #00b39f; }
    .circle-5 { border-color: #0052cc; color: #0052cc; }
    .circle-6 { border-color: #999; color: #999; }
    .circle-7 { border-color: #ff2c74; color: #ff2c74; }
    .circle-8 { border-color: #3bb44a; color: #3bb44a; }

    @media (max-width: 992px) {
      .timeline {
        flex-direction: column;
        align-items: center;
      }

      .timeline::before {
        width: 3px;
        height: 100%;
        left: 50%;
        top: 0;
        transform: translateX(-50%);
      }

      .timeline-item {
        width: 100%;
        margin-bottom: 60px;
      }

      .timeline-item:nth-child(even) .circle {
        margin-top: 0;
      }
    }
  </style>
</head>
<body>
  <section class="roadmap">
    <div class="roadmap-title">
      <h2>ROADMAP INFOGRAPHIC</h2>
      <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed diam nonummy nibh euismod tincidunt.</p>
    </div>

    <div class="timeline">
      <div class="timeline-item">
        <div class="circle circle-1"><i class="fa-regular fa-comment-dots"></i></div>
        <h4>2016</h4>
        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
      </div>
      <div class="timeline-item">
        <div class="circle circle-2"><i class="fa-regular fa-lightbulb"></i></div>
        <h4>2017</h4>
        <p>Prototype and early development.</p>
      </div>
      <div class="timeline-item">
        <div class="circle circle-3"><i class="fa-regular fa-user"></i></div>
        <h4>2018</h4>
        <p>Testing and rollout.</p>
      </div>
      <div class="timeline-item">
        <div class="circle circle-4"><i class="fa-solid fa-magnifying-glass"></i></div>
        <h4>2019</h4>
        <p>Major version launch and updates.</p>
      </div>
      <div class="timeline-item">
        <div class="circle circle-5"><i class="fa-solid fa-gear"></i></div>
        <h4>2020</h4>
        <p>Feature expansion and growth.</p>
      </div>
      <div class="timeline-item">
        <div class="circle circle-6"><i class="fa-solid fa-leaf"></i></div>
        <h4>2021</h4>
        <p>Optimization and scaling.</p>
      </div>
      <div class="timeline-item">
        <div class="circle circle-7"><i class="fa-solid fa-globe"></i></div>
        <h4>2022</h4>
        <p>Global partnerships and outreach.</p>
      </div>
      <div class="timeline-item">
        <div class="circle circle-8"><i class="fa-solid fa-trophy"></i></div>
        <h4>2023</h4>
        <p>New vision and innovation roadmap.</p>
      </div>
    </div>
  </section>
</body>
</html>

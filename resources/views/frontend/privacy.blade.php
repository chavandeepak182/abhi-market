@extends('frontend.layouts.header')

@section('title', 'Privacy Policy - M2Square Consultancy | Expert Market Research Firm')

@section('description', 'Read M2Square Consultancy’s Privacy Policy to understand how we collect, use, and protect your personal information with full transparency and data compliance.')

@section('keywords', 'privacy policy, data protection, GDPR compliance, M2Square Consultancy, personal data')

@section('content')
<style>
  /* --- Privacy Policy Page Styling --- */
  .policy-wrapper {
    background: #f9fafc;
    padding: 80px 0;
  }

  .policy-container {
    border-radius: 12px;
    padding: 50px 60px;
  }

  .policy-container h1 {
    font-weight: 700;
    color: #1a237e;
    margin-bottom: 10px;
  }

  .policy-container p.text-muted {
    font-size: 15px;
    margin-bottom: 40px;
  }

  .policy-container h2 {
    font-size: 1.4rem;
    color: #263238;
    border-left: 4px solid #007bff;
    padding-left: 12px;
    margin-top: 40px;
    margin-bottom: 15px;
    font-weight: 600;
  }

  .policy-container h5 {
    color: #1e88e5;
    margin-top: 15px;
  }

  .policy-container ul {
    margin-left: 1.2rem;
  }

  .policy-container ul li {
    margin-bottom: 6px;
    line-height: 1.6;
  }

  .policy-container p, .policy-container li {
    color: #555;
  }

  .policy-container strong {
    color: #1a237e;
  }

  .policy-container section {
    animation: fadeUp 0.6s ease-in-out;
  }

  @keyframes fadeUp {
    from { opacity: 0; transform: translateY(20px); }
    to { opacity: 1; transform: translateY(0); }
  }

  /* Responsive */
  @media (max-width: 768px) {
    .policy-container {
      padding: 30px 20px;
    }
    .policy-container h1 {
      font-size: 1.8rem;
    }
  }
</style>

<div class="policy-wrapper">
  <div class="container">
    <div class="policy-container">
      <header class="text-center mb-5">
        <h1>Privacy Policy</h1>
        <p class="text-muted">Effective Date: October 2025</p>
      </header>

      <section id="about">
        <h2>1. About M2Square</h2>
        <p>At <strong>M2Square Consultancy</strong>, we believe that great decisions are built on great insights...</p>
      </section>

      <section id="collect">
        <h2>2. Information We Collect</h2>
        <p>We collect information to ensure efficient communication and deliver our services effectively...</p>

        <h5>a. Information You Provide Directly:</h5>
        <ul>
          <li>Name, company name, job title, and contact details.</li>
          <li>Information shared through contact forms or inquiries.</li>
        </ul>

        <h5>b. Information Collected Automatically:</h5>
        <ul>
          <li>IP address, browser details, operating system, and device info.</li>
          <li>Website usage data via cookies and analytics tools.</li>
        </ul>
      </section>

      <section id="use">
        <h2>3. How We Use Your Information</h2>
        <ul>
          <li>To respond to inquiries and deliver services.</li>
          <li>To conduct research, surveys, and analysis.</li>
          <li>To personalize your website experience.</li>
        </ul>
      </section>

      <section id="legal">
        <h2>4. Legal Basis for Processing (GDPR)</h2>
        <ul>
          <li>Your consent for communication and marketing.</li>
          <li>Contractual necessity to provide requested services.</li>
          <li>Legitimate interests in improving products and security.</li>
        </ul>
      </section>

      <section id="share">
        <h2>5. Data Sharing and Disclosure</h2>
        <p>M2Square does not sell or rent personal data...</p>
      </section>

      <section id="retention">
        <h2>6. Data Retention</h2>
        <p>We retain data only as long as necessary...</p>
      </section>

      <section id="cookies">
        <h2>7. Cookies and Tracking</h2>
        <p>We use cookies to enhance user experience...</p>
      </section>

      <section id="security">
        <h2>8. Data Security</h2>
        <p>We implement robust technical and physical safeguards...</p>
      </section>

      <section id="rights">
        <h2>9. Your Rights</h2>
        <ul>
          <li>Access or delete your data.</li>
          <li>Withdraw consent anytime.</li>
          <li>Complain to your local authority.</li>
        </ul>
      </section>

      <section id="updates">
        <h2>10. Updates to This Policy</h2>
        <p>We may periodically update this Privacy Policy...</p>
      </section>
    </div>
  </div>
</div>
@endsection

<?php
session_start();
$verified = isset($_SESSION['verified']) && $_SESSION['verified'] === true;
?>
<!DOCTYPE html>
<html>
<head>
  <title>Secure PDF Access</title>
  <meta charset="utf-8">
  
  
  <style>
  /* Hide content when printing or exporting to PDF */
  @media print {
  body {
  display: none !important;
  }
  .no-print {
  display: none !important;
  }
  }
  /* Watermark for print and potential screenshot deterrence */
  .watermark {
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  opacity: 0.3;
  pointer-events: none;
  z-index: 9999;
  color: red;
  font-size: 50px;
  text-align: center;
  display: none;
  }
  @media print {
  .watermark {
  display: block !important;
  }
  }
  /* Hide content sections by default */
  .content-section {
  display: none;
  opacity: 0;
  transition: opacity 0.5s;
  }
  .content-section.visible {
  display: block;
  opacity: 1;
  }
  /* Obscure content with overlay until clicked */
  .overlay {
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background: rgba(0, 0, 0, 0.8);
  color: white;
  display: flex;
  align-items: center;
  justify-content: center;
  z-index: 10000;
  cursor: pointer;
  }
  </style>
  
  
  
  
  
  
  
  
  
  <style>
    body { font-family: sans-serif; background: #f4f4f4; padding: 40px; }
    #pdf-container{ text-align:centre;}
   /* .container { max-width: 600px; margin: auto; background: white; padding: 30px; border-radius: 12px; box-shadow: 0 0 12px rgba(0,0,0,0.1); }*/
    input, button { width: 100%; padding: 10px; margin-top: 10px; font-size: 16px; }
    img.qr { display: block; margin: 20px auto; width: 250px; }
  </style>
</head>
<body>
  <div class="container">
    <?php if (!$verified): ?>
      <h2>Pay to Access the PDF</h2>
      <p>Scan the QR code below to make payment, then fill in the details.</p>
      <img src="your_qr_code.png" alt="Pay via UPI" class="qr">
      <form method="post" action="verify.php">
        <input type="text" name="name" placeholder="Your Name" required>
        <input type="email" name="email" placeholder="Your Email" required>
        <input type="tel" name="phone" placeholder="Your Phone Number" required>
        <input type="text" name="ref_id" placeholder="UPI Reference Number" required>
        <button type="submit">Submit</button>
      </form>
      
      
      <h1 class="no-print" id="section1" class="content-section">Protected Content</h1>
      <p class="no-print content-section" id="section2">This content is protected. Click to reveal more.</p>
      <button onclick="revealSection(\'section2\')" class="no-print">Show More Content</button>
      
      <div class="watermark">Unauthorized Copy - Do Not Print or Screenshot</div>
      <div class="omverlay" id="omverlay" onclick="removeOverlay()">
      <p>Click to view content. Screenshots and printing are prohibited.</p>
      </div>
      
      
      
      <div id="status" style="margin-top:20px;color:green;"></div>
      
      
      
      
      
      
      
      
      
      
      
      <script>
        setInterval(() => {
          fetch("status.php")
            .then(res => res.text())
            .then(status => {
              if (status.trim() === "approved") {
                window.location.reload();
              }
            });
        }, 3000);
      </script>
    <?php else: ?>
      <h2>Secure PDF Viewer</h2>
      <div id="pdf-container">Loading PDF securely...</div>
      <script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.11.174/pdf.min.js"></script>
      <script>
        const container = document.getElementById('pdf-container');
        const url = 'loader.php';
        pdfjsLib.GlobalWorkerOptions.workerSrc = 'https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.11.174/pdf.worker.min.js';
        pdfjsLib.getDocument(url).promise.then(pdf => {
          for (let i = 1; i <= pdf.numPages; i++) {
            pdf.getPage(i).then(page => {
              const canvas = document.createElement('canvas');
              const context = canvas.getContext('2d');
              const viewport = page.getViewport({ scale: 1.5 });
              canvas.height = viewport.height;
              canvas.width = viewport.width;
              page.render({ canvasContext: context, viewport: viewport });
              container.appendChild(canvas);
            });
          }
        });
        
        // Attempt to detect and block print dialog (limited effectiveness on mobile)
        window.onbeforeprint = function() {
        alert("Printing or PDF conversion is not allowed.");
        return false; // Attempts to cancel print, but may not work on mobile
        };
        
        
      </script>
      
      <script>
      // Block Ctrl+P
      document.addEventListener("keydown", function(event) {
      if (event.ctrlKey && event.key === "p") {
      event.preventDefault();
      alert("Printing or PDF conversion is disabled.");
      }
      });
      
      // Block print dialog (limited effect on mobile)
      window.onbeforeprint = function() {
      alert("Printing or PDF conversion is not allowed.");
      return false;
      };
      
      // Disable right-click
      document.addEventListener("contextmenu", function(e) {
      e.preventDefault();
      alert("Right-click is disabled.");
      });
      
      // Disable text selection
      document.addEventListener("selectstart", function(e) {
      e.preventDefault();
      });
      
      // Show content section only when user interacts
      function revealSection(sectionId) {
      document.getElementById(sectionId).classList.add("visible");
      }
      
      // Detect potential screenshot attempts (very limited)
      window.addEventListener("keydown", function(event) {
      // Detect common screenshot shortcuts (e.g., PrintScreen, Alt+PrintScreen)
      if (event.key === "PrintScreen" || (event.altKey && event.key === "PrintScreen")) {
      alert("Screenshots are not allowed.");
      // Attempt to obscure content
      document.body.style.display = "none";
      setTimeout(() => { document.body.style.display = ""; }, 100);
      }
      });
      
      // Remove overlay when clicked
      function removeOverlay() {
      const overlay = document.getElementById("overlay");
      overlay.style.display = "none";
      revealSection("section1"); // Show first section
      }
      
      
      </script>
      
      
      
      
      
      
    <?php endif; ?>
  </div>
</body>
</html>/html>
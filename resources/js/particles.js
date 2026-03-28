export function initParticleBackground(canvas) {
    if (!canvas) return null;
    const ctx = canvas.getContext('2d');
    if (!ctx) return null;

    let particles = [];
    let animationFrameId;
    let mouseX = -1000;
    let mouseY = -1000;

    const resize = () => {
      const parent = canvas.parentElement;
      if (parent) {
        canvas.width = parent.clientWidth;
        canvas.height = parent.clientHeight;
      } else {
        canvas.width = window.innerWidth;
        canvas.height = window.innerHeight;
      }
      createParticles();
    };

    const createParticles = () => {
      particles = [];
      const density = 8000;
      const particleCount = Math.floor((canvas.width * canvas.height) / density);
      
      for (let i = 0; i < particleCount; i++) {
        particles.push({
          x: Math.random() * canvas.width,
          y: Math.random() * canvas.height,
          vx: (Math.random() - 0.5) * 0.3,
          vy: (Math.random() - 0.5) * 0.3,
          size: Math.random() * 1.5 + 0.5,
          alpha: Math.random() * 0.5 + 0.2,
        });
      }
    };

    const animate = () => {
      ctx.clearRect(0, 0, canvas.width, canvas.height);
      
      particles.forEach((p, index) => {
        p.x += p.vx;
        p.y += p.vy;

        const dx = mouseX - p.x;
        const dy = mouseY - p.y;
        const distance = Math.sqrt(dx * dx + dy * dy);
        const interactionRadius = 150;
        
        if (distance < interactionRadius) {
           const force = (interactionRadius - distance) / interactionRadius;
           const angle = Math.atan2(dy, dx);
           const strength = 0.05;
           p.vx += Math.cos(angle) * force * strength; 
           p.vy += Math.sin(angle) * force * strength;
        }

        p.vx *= 0.96;
        p.vy *= 0.96;
        p.vx += (Math.random() - 0.5) * 0.02;
        p.vy += (Math.random() - 0.5) * 0.02;

        if (p.x < 0) p.x = canvas.width;
        if (p.x > canvas.width) p.x = 0;
        if (p.y < 0) p.y = canvas.height;
        if (p.y > canvas.height) p.y = 0;

        ctx.beginPath();
        ctx.arc(p.x, p.y, p.size, 0, Math.PI * 2);
        ctx.fillStyle = `rgba(224, 205, 176, ${p.alpha})`; 
        ctx.fill();

        for (let j = index + 1; j < particles.length; j++) {
           const p2 = particles[j];
           const pdx = p.x - p2.x;
           const pdy = p.y - p2.y;
           const pDist = Math.sqrt(pdx*pdx + pdy*pdy);

           if (pDist < 80) {
              ctx.beginPath();
              ctx.strokeStyle = `rgba(224, 205, 176, ${0.15 * (1 - pDist/80)})`;
              ctx.lineWidth = 0.5;
              ctx.moveTo(p.x, p.y);
              ctx.lineTo(p2.x, p2.y);
              ctx.stroke();
           }
        }

        if (distance < interactionRadius) {
            ctx.beginPath();
            ctx.strokeStyle = `rgba(224, 205, 176, ${0.2 * (1 - distance/interactionRadius)})`;
            ctx.lineWidth = 0.5;
            ctx.moveTo(p.x, p.y);
            ctx.lineTo(mouseX, mouseY);
            ctx.stroke();
        }
      });

      animationFrameId = requestAnimationFrame(animate);
    };

    const handleMouseMove = (e) => {
      const rect = canvas.getBoundingClientRect();
      if (e.clientY >= rect.top - 100 && e.clientY <= rect.bottom + 100) {
          mouseX = e.clientX - rect.left;
          mouseY = e.clientY - rect.top;
      } else {
          mouseX = -1000;
          mouseY = -1000;
      }
    };

    window.addEventListener('resize', resize);
    window.addEventListener('mousemove', handleMouseMove);
    
    resize();
    animate();

    return () => {
      window.removeEventListener('resize', resize);
      window.removeEventListener('mousemove', handleMouseMove);
      cancelAnimationFrame(animationFrameId);
    };
}

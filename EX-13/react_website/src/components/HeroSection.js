// HeroSection.js
import React from 'react';
import './HeroSection.css';

function HeroSection() {
    return (
        <div className="hero-section text-center">
            <h1>It's a <span className="highlight">ReactJS</span> Website</h1>
            <p>Most Calendars are designed for teams. This is designed for freelancers who want a simple way to plan their schedules.</p>
            <button className="btn btn-success">Hire Me</button>
            <button className="btn btn-outline-light ml-3">Download App</button>
        </div>
    );
}

export default HeroSection;

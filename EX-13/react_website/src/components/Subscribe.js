// Subscribe.js
import React from 'react';
import './Subscribe.css';

function Subscribe() {
    return (
        <div className="subscribe-section text-center" id="subscribe">
            <h2>Subscribe</h2>
            <form className="subscribe-form">
                <input type="email" placeholder="yourname@example.com" required />
                <button type="submit" className="btn btn-success">Continue</button>
            </form>
        </div>
    );
}

export default Subscribe;

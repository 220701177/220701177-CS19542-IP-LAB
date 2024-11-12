// Services.js
import React from 'react';
import './Services.css';

function Services() {
    return (
        <div className="services-section text-center" id="services">
            <h2>Services</h2>
            <p>Here are some services I provide</p>
            <div className="container">
                <div className="row">
                    <div className="col-md-6">
                        <div className="service-card">
                            <img src="python-service.png" alt="Python Service"/>
                            <h5>Python</h5>
                            <p>Lorem ipsum dolor sit amet consectetur adipisicing elit.</p>
                        </div>
                    </div>
                    <div className="col-md-6">
                        <div className="service-card">
                            <img src="react-service.png" alt="React Service"/>
                            <h5>React</h5>
                            <p>Lorem ipsum dolor sit amet consectetur adipisicing elit.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    );
}

export default Services;


// App.js
import React from 'react';
import Navbar from './components/Navbar';
import HeroSection from './components/HeroSection';
import Services from './components/Services';
import Subscribe from './components/Subscribe';

function App() {
    return (
        <div>
            <Navbar />
            <HeroSection />
            <Services />
            <Subscribe />
        </div>
    );
}

export default App;

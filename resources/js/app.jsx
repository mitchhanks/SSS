import React from 'react';
import ReactDOM from 'react-dom/client';
import { BrowserRouter as Router, Routes, Route } from 'react-router-dom'; // Import React Router
import Tickets from './Tickets'; // Tickets component
import UserTickets from './UserTickets'; // UserTickets component

const App = () => {
    return (
        <Router>
            <Routes>
                <Route path="/" element={<Tickets />} /> {/* Main Tickets Page */}
                <Route path="/user-tickets/:email" element={<UserTickets />} /> {/* User Tickets Page */}
            </Routes>
        </Router>
    );
};

const root = ReactDOM.createRoot(document.getElementById('app')); // Use createRoot to initialize
root.render(<App />); // Render the App with routing

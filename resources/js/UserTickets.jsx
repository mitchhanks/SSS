import React, { useEffect, useState } from 'react';
import axios from 'axios';
import { useParams } from 'react-router-dom';

const UserTickets = () => {
    const { email } = useParams(); // Extract email from the route params
    const [tickets, setTickets] = useState([]);
    const [currentPage, setCurrentPage] = useState(1);
    const [lastPage, setLastPage] = useState(1);
    const [loading, setLoading] = useState(true);

    // Fetch tickets for the user
    const fetchUserTickets = async (page = 1) => {
        setLoading(true);
        try {
            const response = await axios.get(
                `http://localhost:8000/api/users/${email}/tickets?page=${page}`
            );

            const { data, current_page, last_page } = response.data;
            setTickets(data);
            setCurrentPage(current_page);
            setLastPage(last_page);
        } catch (error) {
            console.error('Error fetching user tickets:', error);
        }
        setLoading(false);
    };

    useEffect(() => {
        fetchUserTickets(); // Initial fetch for page 1
    }, [email]);

    // Handle pagination
    const handlePageChange = (newPage) => {
        if (newPage >= 1 && newPage <= lastPage) {
            fetchUserTickets(newPage);
        }
    };

    if (loading) {
        return <div>Loading tickets...</div>;
    }

    return (
        <div>
            <h1>Tickets for {email}</h1>

            {tickets.length === 0 ? (
                <p>No tickets found for this user.</p>
            ) : (
                <table border="1" cellPadding="10" style={{ width: '100%', borderCollapse: 'collapse' }}>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Subject</th>
                            <th>Content</th>
                            <th>Status</th>
                            <th>Created At</th>
                        </tr>
                    </thead>
                    <tbody>
                        {tickets.map((ticket) => (
                            <tr key={ticket.id}>
                                <td>{ticket.id}</td>
                                <td>{ticket.subject}</td>
                                <td>{ticket.content}</td>
                                <td>{ticket.status === 0 ? 'Open' : 'Closed'}</td>
                                <td>{new Date(ticket.created_at).toLocaleString()}</td>
                            </tr>
                        ))}
                    </tbody>
                </table>
            )}

            {/* Pagination Controls */}
            <div style={{ marginTop: '20px' }}>
                <button
                    onClick={() => handlePageChange(currentPage - 1)}
                    disabled={currentPage === 1}
                >
                    Previous
                </button>
                <span style={{ margin: '0 10px' }}>
                    Page {currentPage} of {lastPage}
                </span>
                <button
                    onClick={() => handlePageChange(currentPage + 1)}
                    disabled={currentPage === lastPage}
                >
                    Next
                </button>
            </div>
        </div>
    );
};

export default UserTickets;

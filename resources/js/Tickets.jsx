import React, { useEffect, useState } from "react";
import axios from "axios";
import { Link } from 'react-router-dom'; // Import Link for navigation

const Tickets = () => {
    const [tickets, setTickets] = useState([]);
    const [filter, setFilter] = useState("open"); // 'open' or 'closed'
    const [page, setPage] = useState(1); // Current page
    const [totalPages, setTotalPages] = useState(1); // Total number of pages
    const [loading, setLoading] = useState(true);

    // Fetch tickets based on the current filter and page
    const fetchTickets = async () => {
        setLoading(true);
        try {
            const endpoint =
                filter === "open"
                    ? "http://localhost:8000/api/tickets/open"
                    : "http://localhost:8000/api/tickets/closed";

            const response = await axios.get(endpoint, { params: { page } });
            setTickets(response.data.data); // Tickets for the current page
            setTotalPages(response.data.last_page); // Total pages from the API
        } catch (error) {
            console.error("Error fetching tickets:", error);
        }
        setLoading(false);
    };

    // Fetch tickets whenever the filter or page changes
    useEffect(() => {
        fetchTickets();
    }, [filter, page]);

    // Handle ticket filtering
    const handleFilterChange = (newFilter) => {
        setFilter(newFilter);
        setPage(1); // Reset to the first page when switching filters
    };

    // Handle real-time updates (simulate polling every 5 seconds)
    useEffect(() => {
        const interval = setInterval(fetchTickets, 5000);
        return () => clearInterval(interval);
    }, [filter, page]);

    // Render loading state
    if (loading) {
        return <div>Loading...</div>;
    }

    return (
        <div>
            <h1>Ticket View</h1>

            {/* Filter Options */}
            <div>
                <button
                    onClick={() => handleFilterChange("open")}
                    disabled={filter === "open"}
                >
                    View Open Tickets
                </button>
                <button
                    onClick={() => handleFilterChange("closed")}
                    disabled={filter === "closed"}
                >
                    View Closed Tickets
                </button>
            </div>

            {/* Tickets Table */}
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Title</th>
                        <th>Assigned User</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    {tickets.map((ticket) => (
                        <tr key={ticket.id}>
                            <td>{ticket.id}</td>
                            <td>{ticket.title}</td>
                            <td>{ticket.user?.name || "N/A"}</td>
                            <td>{filter === "open" ? "Open" : "Closed"}</td>
                            <td>
                                {/* Link to User Tickets */}
                                <Link to={`/user-tickets/${ticket.user?.email}`}>View User Tickets</Link>
                            </td>
                        </tr>
                    ))}
                </tbody>
            </table>

            {/* Pagination Controls */}
            <div>
                <button
                    onClick={() => setPage((prev) => Math.max(prev - 1, 1))}
                    disabled={page === 1}
                >
                    Previous
                </button>
                <span>
                    Page {page} of {totalPages}
                </span>
                <button
                    onClick={() => setPage((prev) => Math.min(prev + 1, totalPages))}
                    disabled={page === totalPages}
                >
                    Next
                </button>
            </div>
        </div>
    );
};

export default Tickets;

import { useState, useEffect } from 'react';
import axiosClient from '../axios_client';
import { Link } from 'react-router-dom';

export default function Customers() {
    const [customers, setCustomers] = useState([]);
    const [filteredCustomers, setFilteredCustomers] = useState([]);
    const [branches, setBranches] = useState([]);
    const [branchFilter, setBranchFilter] = useState('');
    const [genderFilter, setGenderFilter] = useState('');
    const [currentPage, setCurrentPage] = useState(1);
    const [lastPage, setLastPage] = useState(1);

    const [summary, setSummary] = useState({
        total_customer_count: 0,
        total_male_customer_count: 0,
        total_female_customer_count: 0,
    });



    useEffect(() => {
        getCustomers(currentPage);
    }, [currentPage]);



    const getCustomers = (page) => {
        axiosClient.get(`/customers?page=${page}`)
            .then(({ data }) => {
                setCustomers(data.data); // Current page data
                setFilteredCustomers(data.data);
                extractBranches(data.data); // Extract unique branches
                setCurrentPage(data.current_page); // Current page number
                setLastPage(data.last_page); // Last page number
                setSummary({
                    total_customer_count: data.total_customer_count,
                    total_male_customer_count: data.total_male_customer_count,
                    total_female_customer_count: data.total_female_customer_count,
                });
            })
            .catch((error) => {
                console.error("Error fetching customers:", error);
            });
    };

    const handlePageChange = (page) => {
        if (page >= 1 && page <= lastPage) {
            setCurrentPage(page);
        }
    };

    const getVisiblePages = () => {
        const pages = [];
        const startPage = Math.max(1, currentPage - 2); // Show up to 2 pages before current page
        const endPage = Math.min(lastPage, currentPage + 1); // Show up to 2 pages after current page

        for (let i = startPage; i <= endPage; i++) {
            pages.push(i);
        }

        return pages;
    };

    const extractBranches = (data) => {
        const uniqueBranches = [...new Set(data.map(customer => customer.branch_id))];
        setBranches(uniqueBranches);
    };

    const handleFilterChange = () => {
        let filtered = customers;

        if (branchFilter) {
            filtered = filtered.filter(customer => customer.branch_id === parseInt(branchFilter));
        }

        if (genderFilter) {
            filtered = filtered.filter(customer => customer.gender === genderFilter);
        }

        setFilteredCustomers(filtered);
    };

    useEffect(() => {
        handleFilterChange();
    }, [branchFilter, genderFilter]);

    return (
        <div>
            <div style={{ display: 'flex', justifyContent: 'space-between', alignItems: 'center' }}>
                <h1 className='text-center'>Customers</h1>
                <Link to="/add-customer" className="btn-add">Add New</Link>
            </div>

            <div className="filters">
                <h3>Filters</h3>
                <label>
                    Branch:
                    <select value={branchFilter} onChange={(e) => setBranchFilter(e.target.value)}>
                        <option value="">All Branch</option>
                        {branches.map(branch => (
                            <option key={branch} value={branch}>{branch}</option>
                        ))}
                    </select>
                </label>

                <label>
                    Gender:
                    <select value={genderFilter} onChange={(e) => setGenderFilter(e.target.value)}>
                        <option value="">All Gender</option>
                        <option value="M">Male</option>
                        <option value="F">Female</option>
                    </select>
                </label>
            </div>

            <div className="card animated fadeInDown">
                {/* Summary Information */}
                <div className="summary">
                    <h3>Summary Information:</h3>
                    <p>Total Customers: {summary.total_customer_count}</p>
                    <p>Total Male Customers: {summary.total_male_customer_count}</p>
                    <p>Total Female Customers: {summary.total_female_customer_count}</p>
                </div>

                <table>
                    <thead>
                        <tr>
                            <th>Branch Id</th>
                            <th>First Name</th>
                            <th>Last Name</th>
                            <th>Phone</th>
                            <th>Email</th>
                            <th>Gender</th>
                        </tr>
                    </thead>
                    <tbody>
                        {filteredCustomers.map(customer => (
                            <tr key={customer.id}>
                                <td>{customer.branch_id}</td>
                                <td>{customer.first_name}</td>
                                <td>{customer.last_name}</td>
                                <td>{customer.phone}</td>
                                <td>{customer.email}</td>
                                <td>{customer.gender}</td>
                            </tr>
                        ))}
                    </tbody>
                </table>
                {/* Pagination Controls */}
                <div className="pagination">
                    <button
                        disabled={currentPage === 1}
                        onClick={() => handlePageChange(currentPage - 1)}
                    >
                        Prev
                    </button>

                    {getVisiblePages().map(page => (
                        <button
                            key={page}
                            className={currentPage === page ? "active" : ""}
                            onClick={() => handlePageChange(page)}
                        >
                            {page}
                        </button>
                    ))}

                    {lastPage > 4 && currentPage < lastPage - 2 && <span>...</span>}

                    <button
                        disabled={currentPage === lastPage}
                        onClick={() => handlePageChange(currentPage + 1)}
                    >
                        Next
                    </button>
                </div>
            </div>
        </div>
    );
}

import { useState } from 'react';
import axiosClient from '../axios_client';
import { Link, useNavigate } from 'react-router-dom';

export default function AddCustomer() {
    const navigate = useNavigate();
    const [customer, setCustomer] = useState({
        id: null,
        branch_id: '',
        first_name: '',
        last_name: '',
        phone: '',
        email: '',
        gender: '',
    });
    const [errors, setErrors] = useState(null);

    const onSubmit = (e) => {
        e.preventDefault();
        console.log(customer);

        axiosClient.post(`/customers`, customer)
            .then(() => {
                // TODO show notification
                navigate('/customers');
            })
            .catch(err => {
                const response = err.response;
                if (response.status === 422) {
                    setErrors(response.data.errors)
                }
            })
    }
    return (
        <div>
            <h1>New Customer</h1>
            {errors && <div className='alert'>
                {Object.keys(errors).map(key => (
                    <p key={key}>{errors[key][0]}</p>
                ))}
            </div>
            }
            <form onSubmit={onSubmit}>
                <select onChange={(e) => setCustomer({ ...customer, branch_id: e.target.value })}>
                    <option value="">Select Branch ID... </option>
                    <option value="1">1</option>
                    <option value="2">2</option>
                </select>
                <input type="text" onChange={(e) => setCustomer({ ...customer, first_name: e.target.value })} placeholder='First Name' />
                <input type="text" onChange={(e) => setCustomer({ ...customer, last_name: e.target.value })} placeholder='Last Name' />
                <input type="email" onChange={(e) => setCustomer({ ...customer, email: e.target.value })} placeholder='Email' />
                <input type="text" onChange={(e) => setCustomer({ ...customer, phone: e.target.value })} placeholder='Phone' />
                <select onChange={(e) => setCustomer({ ...customer, gender: e.target.value })}>
                    <option value="">Select Gender...</option>
                    <option value="M">M</option>
                    <option value="F">F</option>
                </select>
                <button className='btn'>Submit</button>
                &nbsp;
                <Link to="/customers" className='btn'>Back</Link>
            </form>
        </div>
    )
}

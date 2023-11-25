import React, { useState, useEffect } from 'react';
import axios from 'axios';

function StepsDetail() {
    const [stepsData, setStepsData] = useState([]);

    useEffect(() => {
        axios.get('/api/steps')
            .then(response => {
                setStepsData(response.data);
            })
            .catch(error => {
                console.error('There was an error!', error);
            });
    }, []);

    return (
        <div style={styles.container}>
            <h1 style={styles.title}>歩数詳細</h1>
            <ul>
                {stepsData.map((item, index) => (
                    <li key={index}>
                        {item.date}: {item.steps} 歩
                    </li>
                ))}
            </ul>
        </div>
    );
}

const styles = {
    container: {
        padding: '20px',
        backgroundColor: '#f5f5f5',
        minHeight: '100vh',
    },
    title: {
        color: '#333',
    },
};

export default StepsDetail;

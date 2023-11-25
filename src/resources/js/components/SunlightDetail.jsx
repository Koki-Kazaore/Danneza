import React, { useState, useEffect } from 'react';
import axios from 'axios';

function SunlightDetail() {
    const [sunlightData, setSunlightData] = useState([]);

    useEffect(() => {
        axios.get('/api/sunlight')
            .then(response => {
                setSunlightData(response.data);
            })
            .catch(error => {
                console.error('There was an error!', error);
            });
    }, []);

    return (
        <div style={styles.container}>
            <h1 style={styles.title}>日照時間詳細</h1>
            <ul>
                {sunlightData.map((item, index) => (
                    <li key={index}>
                        {item.date}: {item.hours} 時間
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

export default SunlightDetail;

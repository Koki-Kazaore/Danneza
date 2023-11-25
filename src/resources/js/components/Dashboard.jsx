import React, { useState, useEffect } from 'react';
import axios from 'axios';

function Dashboard() {
    const [data, setData] = useState({ steps: 0, points: 0, sunlight: 0 });

    useEffect(() => {
        // APIからデータを取得
        axios.get('/api/dashboard')
            .then(response => {
                setData(response.data);
            })
            .catch(error => {
                console.error('There was an error!', error);
            });
    }, []);

    return (
        <div style={styles.container}>
            <h1 style={styles.title}>ダッシュボード</h1>
            <div style={styles.stat}>
                <p>今日の歩数: {data.steps}</p>
                <p>獲得ポイント: {data.points}</p>
                <p>日照時間: {data.sunlight} 時間</p>
            </div>
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
    stat: {
        marginTop: '20px',
    },
};

export default Dashboard;

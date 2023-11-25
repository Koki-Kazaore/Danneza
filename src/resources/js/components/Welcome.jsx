import React from 'react';

function Welcome() {
    const handleLogin = () => {
        // LaravelのGoogleログインルートにリダイレクト
        window.location.href = '/login/google';
    };

    return (
        <div style={styles.container}>
            <h1 style={styles.title}>だんねポイント.com</h1>
            <button style={styles.button} onClick={handleLogin}>
                Googleアカウントでログイン
            </button>
        </div>
    );
}

const styles = {
    container: {
        display: 'flex',
        flexDirection: 'column',
        alignItems: 'center',
        justifyContent: 'center',
        height: '100vh',
        background: 'linear-gradient(to right, #ff7e5f, #feb47b)', // 太陽の暖かい色合い
    },
    title: {
        color: '#fff',
        fontSize: '2.5rem',
        marginBottom: '20px',
        textShadow: '0px 0px 10px rgba(255, 255, 255, 0.7)', // 輝きを表現
    },
    button: {
        backgroundColor: '#fff',
        color: '#ff7e5f',
        border: 'none',
        borderRadius: '5px',
        padding: '10px 20px',
        cursor: 'pointer',
        fontSize: '1rem',
        boxShadow: '0px 0px 10px rgba(255, 255, 255, 0.7)', // ボタンにも輝きを
    },
};

export default Welcome;

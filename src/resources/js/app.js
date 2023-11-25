/**
 * First we will load all of this project's JavaScript dependencies which
 * includes React and other helpers. It's a great starting point while
 * building robust, powerful web applications using React + Laravel.
 */

import './bootstrap';

/**
 * Next, we will create a fresh React component instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

import './components/Example';

import React from 'react';
import { createRoot } from 'react-dom/client';
import Welcome from './components/Welcome';

if (document.getElementById('app')) {
    const app = createRoot(document.getElementById('app'));
    app.render(<Welcome />);
}

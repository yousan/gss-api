'use strict';

import GSSCSVUrl from 'gss-csv-url';

const gss_csv_url = new GSSCSVUrl();

const url = 'https://docs.google.com/spreadsheets/d/1m4BI7R-CcjNREH4DUe1xCM3OIVVSGrGx6-7iUtIvUWE/edit#gid=635058114';

console.log(gss_csv_url.url(url));


const buttonClicked = ({target}) => {
    console.log('hoge');
    target.classList.toggle('teal');
};

console.log(document.getElementById('convert-button'));

document.getElementById('convert-button').onclick = buttonClicked;

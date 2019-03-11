'use strict';

import GSSCSVUrl from 'gss-csv-url';
import axiosBase  from 'axios';

const gss_csv_url = new GSSCSVUrl();


// サンプル動作
// const sample_url = 'https://docs.google.com/spreadsheets/d/1m4BI7R-CcjNREH4DUe1xCM3OIVVSGrGx6-7iUtIvUWE/edit#gid=635058114';
// console.log(gss_csv_url.url(sample_url));

const base_url = 'https://gss-api-6g5ky6iza.now.sh/v1.php';

const axios = axiosBase.create({
    baseURL: 'https://gss-api-p2xtmy7uh.now.sh/',
    headers: {
        'Content-Type': 'application/json',
        'X-Requested-With': 'XMLHttpRequest'
    },
    responseType: 'json'
});

const query = 'v1.php?gss_id=1m4BI7R-CcjNREH4DUe1xCM3OIVVSGrGx6-7iUtIvUWE&gid=635058114'; // バックエンドB のURL:port を指定する

axios.get(query)
    .then(function(response) {

        // [4] フロントエンドに対してレスポンスを返す
        res.render('index', response.data);
    })
    .catch(function(error) {
        console.log('ERROR!! occurred in Backend.')
    });

const buttonClicked = ({target}) => {
    /**
     * Inputに入っているURL
     */
    const url = document.getElementById('url').value;
    const gss_id = gss_csv_url.fileid(url);
    const gid = gss_csv_url.gid(url);
    const output_url = base_url + '?gss_id='+gss_id + '&gid='+ gid;

    document.getElementById('output-url').value = output_url;
    target.classList.toggle('teal');
};

document.getElementById('convert-button').onclick = buttonClicked;

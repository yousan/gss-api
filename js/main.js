'use strict';

import GSSCSVUrl from 'gss-csv-url';
import axiosBase from 'axios';

const gss_csv_url = new GSSCSVUrl();

// @see https://stackoverflow.com/a/6941653/2405335
const base_url = location.protocol + '//' + location.hostname + (location.port ? ':' + location.port : '');

/**
 * 実際にエンドポイントへリクエストを投げて結果を表示する。
 */
function request(gss_id, gid) {
    // エンドポイントへのリクエスト
    // e.g. 'v1.php?gss_id=1m4BI7R-CcjNREH4DUe1xCM3OIVVSGrGx6-7iUtIvUWE&gid=635058114';
    const query = 'v1.php?gss_id=' + gss_id + '&gid=' + gid;

    const axios = axiosBase.create({
        baseURL: base_url,
        headers: {
            'Content-Type': 'application/json',
            'X-Requested-With': 'XMLHttpRequest'
        },
        responseType: 'json'
    });

    axios.get(query)
        .then(function (response) {
            // [4] フロントエンドに対してレスポンスを返す
            // res.render('index', response.data);
            document.getElementById('response').value =  JSON.stringify(response.data);
        })
        .catch(function (error) {
            console.log('ERROR!! occurred in Backend.')
        });
}

/**
 * cURLコマンドの表示
 *
 * @type {{}}
 */
const refreshCurl = (gss_id, gid) => {
    const output_url = base_url + '?gss_id=' + gss_id + '&gid=' + gid;

    document.getElementById('output_url').value = output_url;
};

/**
 * ボタン押下時
 *
 * @param target
 */
const refresh = ({target}) => {
    console.log('url changed');

    /**
     * Inputに入っているURL
     */
    const url = document.getElementById('url').value;
    const gss_id = gss_csv_url.fileid(url);
    const gid = gss_csv_url.gid(url);

    refreshCurl(gss_id, gid);
    request(gss_id, gid);
};


// @see https://developer.mozilla.org/en-US/docs/Web/Events/change
document.addEventListener('DOMContentLoaded',function() {
    document.getElementById('url').onchange = refresh;
    refresh(document.getElementById('url'));
    // document.querySelector('select[name="ice-cream"]').onchange=changeEventHandler;
},false);



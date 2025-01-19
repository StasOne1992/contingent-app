function NewSNILS() {
    let n = 0;
    do {
        n = Math.floor(Math.random() * 1000000000);
    }
    while (n <= 1001998)

    snils = String(n);
    if (snils.length == 7) snils = "00" + snils;
    else if (snils.length == 8) snils = "0" + snils;

    con = 0;
    for (let i = 0; i < 9; i++)
        con += snils[i] * (9 - i);

    cons = "";
    do {
        if (con < 10) cons = "0" + con;
        else if (con < 100) cons = con.toString(10);
        else if (con == 100 || con == 101) cons = "00";
        else con -= 101;
    }
    while (cons == "")

    return snils.substring(0, 3) + "-" + snils.substring(3, 6) + "-" + snils.substring(6, 10) + " " + cons;
}

function OneNewSNILS() {
    One.value = NewSNILS();
    if (IsCopyOne.checked) CopyText("One");
}

function LotNewSNILS(Count) {
    snilss = "";
    for (let i = 1; i <= Count; i++)
        snilss += NewSNILS() + "\n";
    Lot.value = snilss;
    if (IsCopyLot.checked) CopyText("Lot");
    if (IsSaveLot.checked) download(Lot.value, 'snils.txt', 'text/plain');
}

function validateSnils(snils) {
    snils = String(snils).replace(/[^0-9]/g, '');
    var result = false;
    if (typeof snils === 'number') {
        snils = snils.toString();
    } else if (typeof snils !== 'string') {
        snils = '';
    }
    if (!snils.length) {
        return false
    } else if (/[^0-9]/.test(snils)) {
        return false
    } else if (snils.length !== 11) {
        return false
    } else {
        var sum = 0;
        for (var i = 0; i < 9; i++) {
            sum += parseInt(snils[i]) * (9 - i);
        }
        var checkDigit = 0;
        if (sum < 100) {
            checkDigit = sum;
        } else if (sum > 101) {
            checkDigit = parseInt(sum % 101);
            if (checkDigit === 100) {
                checkDigit = 0;
            }
        }
        if (checkDigit === parseInt(snils.slice(-2))) {
            result = true;
        } else {
            return false
        }
    }
    return true;
}
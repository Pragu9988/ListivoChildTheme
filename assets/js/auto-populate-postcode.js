jQuery(function ($) {

    const $postcodeInput = $('#listivo_11352');

    // Suburb field wrapper (taxonomy listivo_11337)
    const suburbSelect = document.querySelector(
        '.listivo_11337 .listivo-select-v2'
    );

    console.log("suburbSelect", suburbSelect);

    if (!suburbSelect || !$postcodeInput.length) return;

    let lastValue = '';

    // const observer = new MutationObserver(() => {
    //     const suburbName = suburbSelect.querySelector('.listivo-select-v2__placeholder').innerText.trim();
    //     console.log("suburbName", suburbName);

    //     // Ignore placeholder texts
    //     if (
    //         !suburbName ||
    //         suburbName === lastValue ||
    //         suburbName === 'Select State first' ||
    //         suburbName === 'Location'
    //     ) {
    //         return;
    //     }

    //     lastValue = suburbName;

    //     $.ajax({
    //         url: ajaxurl,
    //         type: 'POST',
    //         dataType: 'json',
    //         data: {
    //             action: 'get_postcode_by_suburb_name',
    //             suburb_name: suburbName
    //         },
    //         success: function (res) {
    //             console.log("res", res);
    //             if (res.success && res.data.postcode) {
    //                 $postcodeInput.val(res.data.postcode);
    //             } else {
    //                 $postcodeInput.val('');
    //             }
    //         }
    //     });
    // });

    // observer.observe(suburbSelect, {
    //     childList: true,
    //     subtree: true,
    //     characterData: true
    // });

});
document.addEventListener('DOMContentLoaded', () => {
    const tabButtons = document.querySelectorAll('.tab-btn');
    const tabPanes = document.querySelectorAll('.tab-pane');

    tabButtons.forEach(btn => {
        btn.addEventListener('click', () => {
            // reset all
            tabButtons.forEach(b => b.classList.remove('text-orange-600', 'border-orange-600', 'border-b-2'));
            tabPanes.forEach(p => p.classList.add('hidden'));

            // activate
            btn.classList.add('text-orange-600', 'border-orange-600', 'border-b-2');
            document.getElementById(btn.dataset.tab).classList.remove('hidden');
        });
    });

    const verify = (type, id) => {
        if (!id) {
            Swal.fire("Enter ID", `Please enter your ${type} Verification ID.`, "warning");
            return;
        }

        const url = `https://new-portal.csoft.live/api/verify-${type}/${id}`;
        fetch(url)
            .then(res => res.json())
            .then(response => {
                if (response.status === 'success') {
                    const html = `
            <p><strong>Name:</strong> ${response.name}</p>
            <p><strong>Roll Number:</strong> ${response.roll_number}</p>
            <p><strong>Course:</strong> ${response.course_completed}</p>
            <p><strong>Duration:</strong> ${response.course_duration}</p>
            <p class="mt-4">Congratulations, <strong>${response.name}</strong>! Your ${type} has been verified.</p>
          `;
                    Swal.fire(`${type} Verified`, html, 'success');
                } else {
                    showError(type);
                }
            })
            .catch(() => {
                showError(type);
            });
    };

    const showError = (type) => {
        Swal.fire(
            `${type} Not Verified`,
            `
      <p>Unfortunately, your ${type} could not be verified.</p>
      <p>Please contact administration for assistance.</p>
      <p><strong>Email:</strong> <a href="mailto:verifications@career.edu.pk">verifications@career.edu.pk</a></p>
      <p><strong>Call:</strong> <a href="tel:+923144444010">+92-314-4444010</a></p>
      `,
            "error"
        );
    };

    document.getElementById('certificate_btn').addEventListener('click', () => {
        const id = document.getElementById('certificate_id').value.trim();
        verify('certificate', id);
    });

    document.getElementById('internship_btn').addEventListener('click', () => {
        const id = document.getElementById('internship_id').value.trim();
        verify('internship', id);
    });

    document.getElementById('experience_btn').addEventListener('click', () => {
        const id = document.getElementById('experience_id').value.trim();
        verify('experience', id);
    });
});

<?php
// show potential errors / feedback (from login object)
if (isset($login)) {
	if ($login->errors) {
		foreach ($login->errors as $error) {
			echo $error;
		}
	}
	if ($login->messages) {
		foreach ($login->messages as $message) {
			echo $message;
		}
	}
}
?>

<?php
// show potential errors / feedback (from registration object)
if (isset($registration)) {
    if ($registration->errors) {
        foreach ($registration->errors as $error) {
            echo $error;
        }
    }
    if ($registration->messages) {
        foreach ($registration->messages as $message) {
            echo $message;
        }
    }
}
?>

<?php
// show potential errors / feedback (from registration object)
if (isset($groups)) {
    if ($groups->errors) {
        foreach ($groups->errors as $error) {
            echo $error;
        }
    }
    if ($groups->messages) {
        foreach ($groups->messages as $message) {
            echo $message;
        }
    }
}
?>

<?php
// show potential errors / feedback (from registration object)
if (isset($users)) {
    if ($users->errors) {
        foreach ($users->errors as $error) {
            echo $error;
        }
    }
    if ($users->messages) {
        foreach ($users->messages as $message) {
            echo $message;
        }
    }
}

if (isset($Keywords)) {
	if ($Keywords->errors) {
		foreach ($Keywords->errors as $error) {
			echo $error;
		}
	}
	if ($Keywords->messages) {
		foreach ($Keywords->messages as $message) {
			echo $message;
		}
	}
}

if (isset($files)) {
	if ($files->errors) {
		foreach ($files->errors as $error) {
			echo $error;
		}
	}
	if ($files->messages) {
		foreach ($files->messages as $message) {
			echo $message;
		}
	}
}
?>

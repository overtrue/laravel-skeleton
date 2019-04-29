<?php

Route::view('/dashboard/{path?}', 'dashboard.app')->where('path', '[\w\-/]+');

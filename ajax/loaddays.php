<?php

require_once('../bootstrap.php');

if ($_GET['type'] == "days") {

    $month = $_GET['month'];

    if ($month == "January" || $month == "March" || $month == "May" || $month == "July" || $month == "August" || $month == "October" || $month == "December") {
        for ($i = 1; $i <= 31; $i++) {
            $days .= "<option value='$i'>$i</option>";
        }
        echo $days;

    } elseif ($month == "April" || $month == "June" || $month == "September" || $month == "November") {
        for ($i = 1; $i <= 30; $i++) {
            $days .= "<option value='$i'>$i</option>";
        }
        echo $days;
    } else //february
    {
        for ($i = 1; $i <= 29; $i++) {
            $days .= "<option value='$i'>$i</option>";
        }
        echo $days;

    }//else

}//end if

elseif ($_GET['type'] == "brthdays") {
    $month = $_GET['month'];
    $members = $classManager->searchMembersBirthday($month);
    $sum = count($members);

    ?>
    <?php if ($sum != 0) { ?>

        <table width="100%">
        <tr>
            <td colspan="6"><?php echo "You have " . $sum . " Student(s) born in the month of " . $month; ?></td>
        </tr>
        <tr align="center" valign="middle" class="tableheader">
            <td><span class="style9">S/N</span></td>
            <td><span class="style9">NAME</span></td>
            <td><span class="style9">DATE OF BIRTH</span></td>
            <td><span class="style9">EMAIL</span></td>
            <td><span class="style9">PHONE</span></td>
            <td><span class="style9">HALL/RMN</span></td>
        </tr>

        <?php
        $i = 0;
        foreach ($members as $member) {
            if ($i % 2 == 0) {
                $class = "t1";
                $i++;
            } else {
                $class = "t2";
                $i++;
            }
            ?>
            <tr class="<?php echo $class; ?>">
                <td align="center" valign="top"><?php echo $i; ?></td>

                <td align="center" valign="middle"><span
                            class="style5"><?php echo $member['fname'] . " " . $member['lname']; ?></span></td>
                <td align="left" valign="middle"><span class="style6"><?php echo $member['dob']; ?></span></td>
                <td align="left" valign="middle"><span class="style6"><?php echo $member['email']; ?></span></td>
                <td align="left" valign="middle"><span class="style7"><?php echo $member['phone']; ?></span></td>
                <td align="left" valign="middle"><span
                            class="style7"><?php echo $member['roomno']; ?></span></td>

            </tr>
        <?php } ?>
        </table><?php } ?>

    <?php if ($sum == 0) { ?>
        <table width="100%">
            <tr>
                <td>No student was born in the month of<?php echo " " . $month; ?></td>
            </tr>
        </table>
    <?php } ?>
<?php }//end elseif?>


<?php
if ($_GET['type'] == "search") {
    $data = $_GET['keyword'];
    $member = $classManager->getStudent($data);
    $sum2 = count($member);

    if ($sum2 != 0) { ?>
        <table width="100%">
        <tr align="center" valign="middle" class="tableheader">
            <td><span class="style9">NAME</span></td>
            <td><span class="style9">DATE OF BIRTH</span></td>
            <td><span class="style9">EMAIL</span></td>
            <td><span class="style9">PHONE</span></td>
            <td><span class="style9">HALL/RMN</span></td>
        </tr>
        <tr class="t1">
            <td align="center" valign="middle"><span style="color: black"><?php echo $member[0]['fname'] . " " . $member[0]['lname']; ?></span></td>
            <td align="left" valign="middle"><span class="style6"><?php echo $member[0]['dob']; ?></span></td>
            <td align="left" valign="middle"><span class="style6"><?php echo $member[0]['email']; ?></span></td>
            <td align="left" valign="middle"><span class="style7"><?php echo $member[0]['phone']; ?></span></td>
            <td align="left" valign="middle"><span class="style7"><?php echo $member[0]['roomno']; ?></span></td>
        </tr>
        </table><?php } ?>

    <?php if ($sum2 == 0) { ?>
        <table width="100%">
            <tr>
                <td>No student with matric Number <strong><?php echo $data . " "; ?></strong>in this class</td>
            </tr>
        </table>
    <?php } ?>

<?php } ?>

bin_mapping = {}

for i in range(1, 12):
    bin_mapping['A' + str(i)] = i
    bin_mapping['B' + str(i)] = i

for i in range(14, 25):
    bin_mapping['C' + str(i - 13)] = i
    bin_mapping['D' + str(i - 13)] = i

for i in range(27, 38):
    bin_mapping['E' + str(i - 26)] = i
    bin_mapping['F' + str(i - 26)] = i

for i in range(40, 51):
    bin_mapping['G' + str(i - 39)] = i

bin_mapping['start'] = 14

print(bin_mapping)
